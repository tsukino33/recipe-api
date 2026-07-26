<?php

namespace App\Services;

use App\Models\Recipe;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class RecipeImporter
{
    /**
     * Fetch a recipe page, extract its schema.org/Recipe structured data,
     * and save it as a new Recipe row.
     */
    public function importFromUrl(string $url): Recipe
    {
        $html = $this->fetchHtml($url);
        $data = $this->extractRecipeSchema($html);

        if (! $data) {
            throw new RuntimeException(
                'No structured recipe data found on that page. Most recipe '.
                'sites embed schema.org data for Google search results — '.
                'this page either doesn\'t have it or structures it unusually.'
            );
        }

        return Recipe::create($this->mapToRecipeAttributes($data, $url));
    }

    protected function fetchHtml(string $url): string
    {
        $response = Http::withHeaders([
            // Some sites block requests with no/unfamiliar User-Agent.
            'User-Agent' => 'Mozilla/5.0 (compatible; RecipeRolodexImporter/1.0; personal recipe collector)',
            'Accept' => 'text/html',
        ])->timeout(15)->get($url);

        if (! $response->successful()) {
            throw new RuntimeException("Could not fetch that URL (HTTP {$response->status()}).");
        }

        return $response->body();
    }

    /**
     * Look through every <script type="application/ld+json"> block on the
     * page for an entry whose @type is "Recipe" (handles both a single
     * object and a top-level array, and the @graph wrapper some sites use).
     */
    protected function extractRecipeSchema(string $html): ?array
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_use_internal_errors(false);

        $xpath = new DOMXPath($dom);
        $scripts = $xpath->query('//script[@type="application/ld+json"]');

        foreach ($scripts as $script) {
            $json = json_decode($script->textContent, true);
            if (! is_array($json)) {
                continue;
            }

            // Normalize to a flat list of candidate objects to check.
            if (array_is_list($json)) {
                $candidates = $json;
            } elseif (isset($json['@graph']) && is_array($json['@graph'])) {
                $candidates = $json['@graph'];
            } else {
                $candidates = [$json];
            }

            foreach ($candidates as $entry) {
                if (! is_array($entry)) {
                    continue;
                }
                $type = $entry['@type'] ?? null;
                $types = is_array($type) ? $type : [$type];
                if (in_array('Recipe', $types, true)) {
                    return $entry;
                }
            }
        }

        return null;
    }

    protected function mapToRecipeAttributes(array $data, string $sourceUrl): array
    {
        return [
            'title' => $this->str($data['name'] ?? null) ?: 'Untitled Recipe',
            'category' => $this->firstOrDefault($data['recipeCategory'] ?? null, 'Imported'),
            'prep_time' => $this->duration($data['prepTime'] ?? null),
            'cook_time' => $this->duration($data['cookTime'] ?? null),
            'servings' => $this->servings($data['recipeYield'] ?? null),
            // schema.org has no standard difficulty field — default it;
            // easy to edit after import.
            'difficulty' => 'Medium',
            'description' => $this->str($data['description'] ?? '') ?: '',
            'image_url' => $this->image($data['image'] ?? null),
            'ingredients' => $this->stringList($data['recipeIngredient'] ?? $data['ingredients'] ?? []),
            'instructions' => $this->instructions($data['recipeInstructions'] ?? []),
            'tags' => $this->tags($data),
            'source_url' => $sourceUrl,
        ];
    }

    protected function str(mixed $value): ?string
    {
        if (is_array($value)) {
            $value = $value['@value'] ?? reset($value) ?: null;
        }
        return is_string($value) ? trim(strip_tags($value)) : null;
    }

    protected function firstOrDefault(mixed $value, string $default): string
    {
        if (is_array($value)) {
            $value = reset($value);
        }
        $value = $this->str($value);
        return $value ?: $default;
    }

    /**
     * Convert an ISO 8601 duration (e.g. "PT20M", "PT1H30M") into a short
     * display string (e.g. "20 min", "1 hr 30 min") matching how this app
     * stores prep_time/cook_time.
     */
    protected function duration(mixed $iso): string
    {
        $iso = $this->str($iso);
        if (! $iso) {
            return 'N/A';
        }

        try {
            $interval = new \DateInterval($iso);
        } catch (Throwable) {
            return $iso; // fall back to raw string rather than failing the import
        }

        $parts = [];
        if ($interval->h > 0) {
            $parts[] = "{$interval->h} hr";
        }
        if ($interval->i > 0) {
            $parts[] = "{$interval->i} min";
        }

        return $parts ? implode(' ', $parts) : '0 min';
    }

    protected function servings(mixed $yield): int
    {
        if (is_array($yield)) {
            $yield = reset($yield);
        }
        if (is_int($yield)) {
            return max(1, $yield);
        }
        if (is_string($yield) && preg_match('/(\d+)/', $yield, $m)) {
            return max(1, (int) $m[1]);
        }
        return 4; // reasonable default when the source doesn't specify
    }

    protected function image(mixed $image): string
    {
        if (is_array($image)) {
            // Could be a plain list of URL strings, or ImageObject(s) with a "url" key.
            $first = array_is_list($image) ? ($image[0] ?? null) : $image;
            if (is_array($first)) {
                return $first['url'] ?? '';
            }
            return is_string($first) ? $first : '';
        }
        return is_string($image) ? $image : '';
    }

    protected function stringList(mixed $items): array
    {
        if (! is_array($items)) {
            return [];
        }
        return array_values(array_filter(array_map(
            fn ($item) => $this->str($item),
            $items
        )));
    }

    /**
     * recipeInstructions varies a lot across sites: a single string, an
     * array of strings, or an array of HowToStep/HowToSection objects.
     */
    protected function instructions(mixed $raw): array
    {
        if (is_string($raw)) {
            // Split a single blob into lines/sentences as a best effort.
            return array_values(array_filter(array_map('trim', preg_split('/\r?\n+/', $raw))));
        }

        if (! is_array($raw)) {
            return [];
        }

        $steps = [];
        foreach ($raw as $item) {
            if (is_string($item)) {
                $steps[] = trim($item);
            } elseif (is_array($item)) {
                if (isset($item['itemListElement']) && is_array($item['itemListElement'])) {
                    // HowToSection containing nested steps
                    foreach ($item['itemListElement'] as $nested) {
                        $text = $this->str($nested['text'] ?? $nested['name'] ?? null);
                        if ($text) {
                            $steps[] = $text;
                        }
                    }
                } else {
                    $text = $this->str($item['text'] ?? $item['name'] ?? null);
                    if ($text) {
                        $steps[] = $text;
                    }
                }
            }
        }

        return array_values(array_filter($steps));
    }

    protected function tags(array $data): array
    {
        $tags = [];

        $cuisine = $data['recipeCuisine'] ?? null;
        if (is_array($cuisine)) {
            $tags = array_merge($tags, $cuisine);
        } elseif (is_string($cuisine)) {
            $tags[] = $cuisine;
        }

        $keywords = $data['keywords'] ?? null;
        if (is_string($keywords)) {
            $tags = array_merge($tags, array_map('trim', explode(',', $keywords)));
        } elseif (is_array($keywords)) {
            $tags = array_merge($tags, $keywords);
        }

        return array_values(array_unique(array_filter(array_map(
            fn ($t) => strtolower((string) $t),
            $tags
        ))));
    }
}
