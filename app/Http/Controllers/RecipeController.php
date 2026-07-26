<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * GET /api/recipes?search=...&category=...
     */
    public function index(Request $request): JsonResponse
    {
        $search = $request->string('search')->toString();
        $category = $request->string('category')->toString() ?: 'All';

        $recipes = Recipe::query()
            ->search($search)
            ->inCategory($category)
            ->orderBy('title')
            ->get()
            ->map(fn (Recipe $recipe) => $recipe->toFrontend());

        return response()->json($recipes);
    }

    /**
     * GET /api/categories
     */
    public function categories(): JsonResponse
    {
        $categories = collect(['All'])
            ->merge(Recipe::query()->distinct()->orderBy('category')->pluck('category'))
            ->values();

        return response()->json($categories);
    }

    /**
     * GET /api/recipes/{recipe}
     */
    public function show(Recipe $recipe): JsonResponse
    {
        return response()->json($recipe->toFrontend());
    }

    /**
     * POST /api/recipes  — manual create
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $this->validated($request);

        $recipe = Recipe::create($validated);

        return response()->json($recipe->toFrontend(), 201);
    }

    /**
     * PUT/PATCH /api/recipes/{recipe}  — edit (covers both manual edits
     * and re-editing an imported recipe)
     */
    public function update(Request $request, Recipe $recipe): JsonResponse
    {
        $validated = $this->validated($request);

        $recipe->update($validated);

        return response()->json($recipe->toFrontend());
    }

    /**
     * DELETE /api/recipes/{recipe}
     */
    public function destroy(Recipe $recipe): JsonResponse
    {
        $recipe->delete();

        return response()->json(['message' => 'Recipe deleted.']);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'prep_time' => ['required', 'string', 'max:50'],
            'cook_time' => ['required', 'string', 'max:50'],
            'servings' => ['required', 'integer', 'min:1', 'max:999'],
            'difficulty' => ['required', 'in:Easy,Medium,Hard'],
            'description' => ['required', 'string'],
            'image_url' => ['required', 'string', 'max:2048'],
            'ingredients' => ['required', 'array', 'min:1'],
            'ingredients.*' => ['required', 'string'],
            'instructions' => ['required', 'array', 'min:1'],
            'instructions.*' => ['required', 'string'],
            'tags' => ['required', 'array'],
            'tags.*' => ['string'],
        ]);
    }
}
