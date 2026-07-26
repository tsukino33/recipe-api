<?php

namespace App\Http\Controllers;

use App\Services\RecipeImporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class RecipeImportController extends Controller
{
    /**
     * POST /api/recipes/import  { "url": "https://..." }
     */
    public function store(Request $request, RecipeImporter $importer): JsonResponse
    {
        $validated = $request->validate([
            'url' => ['required', 'url'],
        ]);

        try {
            $recipe = $importer->importFromUrl($validated['url']);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($recipe->toFrontend(), 201);
    }
}
