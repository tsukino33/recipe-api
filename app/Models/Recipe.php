<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'description',
        'image_url',
        'ingredients',
        'instructions',
        'tags',
        'source_url',
    ];

    // JSON columns are automatically decoded to arrays / encoded back to JSON.
    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
        'tags' => 'array',
        'servings' => 'integer',
    ];

    /**
     * Scope: filter by search term against title or tags.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhereJsonContains('tags', strtolower($term))
              // fallback for partial tag matches (JSON_CONTAINS needs exact values,
              // so also do a raw LIKE against the json column for partial matches)
              ->orWhere('tags', 'like', "%{$term}%");
        });
    }

    /**
     * Scope: filter by category ("All" is treated as no filter).
     */
    public function scopeInCategory(Builder $query, ?string $category): Builder
    {
        if (blank($category) || $category === 'All') {
            return $query;
        }

        return $query->where('category', $category);
    }

    /**
     * Shape the model for the frontend, matching the original
     * RecipeSpinner.tsx `Recipe` interface (camelCase keys).
     */
    public function toFrontend(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'prepTime' => $this->prep_time,
            'cookTime' => $this->cook_time,
            'servings' => $this->servings,
            'difficulty' => $this->difficulty,
            'description' => $this->description,
            'imageUrl' => $this->image_url,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'tags' => $this->tags,
            'sourceUrl' => $this->source_url,
        ];
    }
}
