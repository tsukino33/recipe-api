<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $recipes = [
            [
                'title' => 'Classic Spaghetti Carbonara',
                'category' => 'Italian',
                'prep_time' => '10 min',
                'cook_time' => '20 min',
                'servings' => 4,
                'difficulty' => 'Medium',
                'description' => 'Silky, rich pasta from Rome — no cream needed, just eggs and aged cheese.',
                'image_url' => 'https://images.unsplash.com/photo-1546549032-9571cd6b27df?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['400g spaghetti', '200g pancetta', '4 eggs', '100g Pecorino Romano', 'Black pepper', 'Salt'],
                'instructions' => [
                    'Bring a large pot of salted water to boil and cook spaghetti according to package directions.',
                    'Meanwhile, cook pancetta in a large skillet until crispy.',
                    'Whisk eggs and grated Pecorino together in a bowl.',
                    'Drain pasta, reserving 1 cup pasta water. Add hot pasta to pancetta.',
                    'Remove from heat, add egg mixture, tossing quickly. Add pasta water to create creamy sauce.',
                    'Season generously with black pepper and serve immediately.',
                ],
                'tags' => ['pasta', 'italian', 'dinner', 'quick'],
            ],
            [
                'title' => 'Chicken Tikka Masala',
                'category' => 'Indian',
                'prep_time' => '30 min',
                'cook_time' => '40 min',
                'servings' => 6,
                'difficulty' => 'Medium',
                'description' => 'Tender marinated chicken in a fragrant, velvety tomato-cream sauce.',
                'image_url' => 'https://images.unsplash.com/photo-1603894584373-5ac82b2ae398?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['800g chicken breast', '1 cup yogurt', '2 tbsp tikka masala paste', '400ml coconut cream', '1 can tomatoes', '1 onion', '4 cloves garlic', '2 tsp garam masala', 'Fresh cilantro', 'Rice for serving'],
                'instructions' => [
                    'Marinate chicken in yogurt and half the tikka masala paste for 30 minutes.',
                    'Cook chicken in a hot pan until charred and cooked through. Set aside.',
                    'Sauté onion and garlic until soft, add remaining tikka masala paste and garam masala.',
                    'Add canned tomatoes and simmer for 10 minutes.',
                    'Stir in coconut cream and return chicken to pan.',
                    'Simmer for 15 minutes. Garnish with cilantro and serve with rice.',
                ],
                'tags' => ['indian', 'curry', 'chicken', 'dinner'],
            ],
            [
                'title' => 'Avocado Toast & Poached Eggs',
                'category' => 'Breakfast',
                'prep_time' => '5 min',
                'cook_time' => '10 min',
                'servings' => 2,
                'difficulty' => 'Easy',
                'description' => 'Creamy smashed avocado on toasted sourdough, crowned with perfectly runny eggs.',
                'image_url' => 'https://images.unsplash.com/photo-1513442542250-854d436a73f2?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['2 ripe avocados', '4 slices sourdough bread', '4 eggs', '1 tbsp white vinegar', 'Cherry tomatoes', 'Red pepper flakes', 'Salt and pepper', 'Olive oil'],
                'instructions' => [
                    'Toast sourdough bread until golden and crispy.',
                    'Bring a pot of water to gentle simmer, add vinegar.',
                    'Crack eggs into small cups, then gently slide into water. Poach for 3-4 minutes.',
                    'Mash avocados with salt, pepper, and olive oil.',
                    'Spread avocado on toast, top with poached eggs.',
                    'Garnish with halved cherry tomatoes and red pepper flakes.',
                ],
                'tags' => ['breakfast', 'healthy', 'vegetarian', 'quick'],
            ],
            [
                'title' => 'Beef Tacos with Fresh Salsa',
                'category' => 'Mexican',
                'prep_time' => '15 min',
                'cook_time' => '15 min',
                'servings' => 4,
                'difficulty' => 'Easy',
                'description' => 'Smoky seasoned beef loaded into crispy shells with bright hand-chopped salsa.',
                'image_url' => 'https://images.unsplash.com/photo-1552332386-f8dd00dc2f85?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['500g ground beef', '8 taco shells', '2 tomatoes', '1 onion', '1 jalapeño', 'Lime juice', 'Cilantro', 'Lettuce', 'Cheddar cheese', 'Sour cream', 'Taco seasoning'],
                'instructions' => [
                    'Cook ground beef with taco seasoning until browned.',
                    'Dice tomatoes, onion, and jalapeño. Mix with lime juice and cilantro for salsa.',
                    'Warm taco shells in oven.',
                    'Shred lettuce and grate cheese.',
                    'Assemble tacos with beef, lettuce, cheese, salsa, and sour cream.',
                    'Serve immediately with extra lime wedges.',
                ],
                'tags' => ['mexican', 'tacos', 'dinner', 'quick'],
            ],
            [
                'title' => 'Classic Caesar Salad',
                'category' => 'Salad',
                'prep_time' => '15 min',
                'cook_time' => '0 min',
                'servings' => 4,
                'difficulty' => 'Easy',
                'description' => 'Crisp romaine with a proper anchovy-lemon dressing and hand-shaved Parmesan.',
                'image_url' => 'https://images.unsplash.com/photo-1746211108786-ca20c8f80ecd?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['2 romaine lettuce heads', '1 cup croutons', '1/2 cup Parmesan', '2 cloves garlic', '2 anchovy fillets', '1 egg yolk', '1 tbsp Dijon mustard', '3 tbsp lemon juice', '1/2 cup olive oil', 'Salt and pepper'],
                'instructions' => [
                    'Wash and chop romaine lettuce into bite-sized pieces.',
                    'Make dressing: blend garlic, anchovies, egg yolk, mustard, and lemon juice.',
                    'Slowly drizzle in olive oil while blending until emulsified.',
                    'Season dressing with salt and pepper.',
                    'Toss lettuce with dressing.',
                    'Top with croutons and shaved Parmesan. Serve immediately.',
                ],
                'tags' => ['salad', 'vegetarian', 'side', 'quick'],
            ],
            [
                'title' => 'Chocolate Chip Cookies',
                'category' => 'Dessert',
                'prep_time' => '15 min',
                'cook_time' => '12 min',
                'servings' => 24,
                'difficulty' => 'Easy',
                'description' => 'Bakery-style cookies — crispy edges, chewy centers, pools of melted chocolate.',
                'image_url' => 'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['2 1/4 cups flour', '1 tsp baking soda', '1 tsp salt', '1 cup butter', '3/4 cup sugar', '3/4 cup brown sugar', '2 eggs', '2 tsp vanilla', '2 cups chocolate chips'],
                'instructions' => [
                    'Preheat oven to 375°F (190°C).',
                    'Mix flour, baking soda, and salt in a bowl.',
                    'Beat butter and both sugars until creamy. Add eggs and vanilla.',
                    'Gradually blend in flour mixture.',
                    'Stir in chocolate chips.',
                    'Drop spoonfuls onto baking sheets. Bake 9-11 minutes until golden. Cool before serving.',
                ],
                'tags' => ['dessert', 'cookies', 'baking', 'sweet'],
            ],
            [
                'title' => 'Thai Green Curry',
                'category' => 'Thai',
                'prep_time' => '20 min',
                'cook_time' => '25 min',
                'servings' => 4,
                'difficulty' => 'Medium',
                'description' => 'Fragrant coconut-based curry with herbs, tender chicken, and vibrant vegetables.',
                'image_url' => 'https://images.unsplash.com/photo-1616278842935-f36557148755?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['400g chicken thigh', '2 tbsp green curry paste', '400ml coconut milk', '1 cup chicken stock', '2 tbsp fish sauce', '1 tbsp palm sugar', 'Thai basil', 'Vegetables (eggplant, bamboo shoots)', 'Jasmine rice'],
                'instructions' => [
                    'Heat oil and fry curry paste until fragrant.',
                    'Add chicken and cook until no longer pink.',
                    'Pour in half the coconut milk, bring to simmer.',
                    'Add vegetables, remaining coconut milk, stock, fish sauce, and sugar.',
                    'Simmer for 15 minutes until vegetables are tender.',
                    'Stir in Thai basil and serve over jasmine rice.',
                ],
                'tags' => ['thai', 'curry', 'chicken', 'spicy'],
            ],
            [
                'title' => 'Margherita Pizza',
                'category' => 'Italian',
                'prep_time' => '90 min',
                'cook_time' => '15 min',
                'servings' => 2,
                'difficulty' => 'Hard',
                'description' => 'Neapolitan-style with blistered crust, fresh mozzarella, and fragrant basil.',
                'image_url' => 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=600&h=400&fit=crop&auto=format',
                'ingredients' => ['Pizza dough', '1 cup tomato sauce', '200g fresh mozzarella', 'Fresh basil', 'Olive oil', 'Salt', 'Flour for dusting'],
                'instructions' => [
                    'Let pizza dough rise for 1-2 hours at room temperature.',
                    'Preheat oven to highest setting (500°F/260°C) with pizza stone inside.',
                    'Stretch dough on floured surface into 12-inch circle.',
                    'Spread tomato sauce, leaving 1-inch border.',
                    'Tear mozzarella and distribute over sauce.',
                    'Transfer to hot pizza stone, bake 10-15 minutes. Top with fresh basil and olive oil.',
                ],
                'tags' => ['italian', 'pizza', 'dinner', 'vegetarian'],
            ],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }
    }
}
