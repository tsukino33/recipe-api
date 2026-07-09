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
}
