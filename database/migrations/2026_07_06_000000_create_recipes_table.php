<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->index();
            $table->string('prep_time');   // kept as display strings ("10 min") to match the original UI
            $table->string('cook_time');
            $table->unsignedSmallInteger('servings');
            $table->enum('difficulty', ['Easy', 'Medium', 'Hard'])->index();
            $table->text('description');
            $table->string('image_url');
            $table->json('ingredients');
            $table->json('instructions');
            $table->json('tags');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
