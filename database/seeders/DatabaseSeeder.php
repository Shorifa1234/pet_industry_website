<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Company;
use App\Models\Product;
use App\Models\Event;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@foodindustry.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Editor John',
            'email' => 'editor@foodindustry.com',
            'password' => bcrypt('editor123'),
            'role' => 'editor',
            'is_active' => true,
        ]);

        // Categories
        $articleCats = ['Ingredients', 'Processing & Technology', 'Packaging', 'Regulatory & Safety', 'Market Trends', 'Sustainability', 'New Products', 'Events & Trade Shows'];
        foreach ($articleCats as $name) {
            Category::create(['name' => $name, 'slug' => Str::slug($name), 'type' => 'article', 'is_active' => true]);
        }

        $productCats = ['Ingredients', 'Beverages', 'Snacks & Confectionery', 'Dairy', 'Bakery', 'Packaging Solutions', 'Processing Equipment'];
        foreach ($productCats as $name) {
            Category::create(['name' => $name, 'slug' => Str::slug($name) . '-prod', 'type' => 'product', 'is_active' => true]);
        }

        // Companies
        $companies = [
            ['name' => 'GlobalFood Ingredients Ltd', 'country' => 'USA', 'city' => 'Chicago', 'industry_type' => 'Ingredients', 'is_featured' => true],
            ['name' => 'TechPackage Solutions', 'country' => 'Germany', 'city' => 'Berlin', 'industry_type' => 'Packaging', 'is_featured' => true],
            ['name' => 'Fresh Dairy International', 'country' => 'Netherlands', 'city' => 'Amsterdam', 'industry_type' => 'Dairy', 'is_featured' => true],
            ['name' => 'BevTech Industries', 'country' => 'UK', 'city' => 'London', 'industry_type' => 'Beverages', 'is_featured' => true],
            ['name' => 'AsiaPac Foods Group', 'country' => 'Singapore', 'city' => 'Singapore', 'industry_type' => 'Processing', 'is_featured' => true],
            ['name' => 'NutriScience Corp', 'country' => 'USA', 'city' => 'New York', 'industry_type' => 'Nutraceuticals', 'is_featured' => false],
        ];

        foreach ($companies as $data) {
            Company::create(array_merge($data, [
                'slug' => Str::slug($data['name']) . '-' . time() . rand(10, 99),
                'status' => 'active',
                'description' => 'Leading ' . $data['industry_type'] . ' company with decades of experience in the food & beverage industry, providing innovative solutions to manufacturers worldwide.',
                'email' => 'info@' . Str::slug($data['name']) . '.com',
                'website' => 'https://www.' . Str::slug($data['name']) . '.com',
            ]));
        }

        // Articles
        $articleTitles = [
            ['title' => 'Global Food & Beverage Market Expected to Reach $9 Trillion by 2028', 'cat' => 'Market Trends'],
            ['title' => 'New EU Regulations on Food Labeling: What Manufacturers Need to Know', 'cat' => 'Regulatory & Safety'],
            ['title' => 'Sustainable Packaging: Industry Leaders Share Best Practices', 'cat' => 'Sustainability'],
            ['title' => 'Plant-Based Proteins: The Fastest Growing Ingredient Category in 2025', 'cat' => 'Ingredients'],
            ['title' => 'Smart Processing Technology Reduces Production Costs by 30%', 'cat' => 'Processing & Technology'],
            ['title' => 'Top 10 Trends Shaping the Beverage Industry in 2025', 'cat' => 'Market Trends'],
            ['title' => 'Food Safety Alert: Updated HACCP Guidelines Released', 'cat' => 'Regulatory & Safety'],
            ['title' => 'Biodegradable Packaging Solutions Gain Momentum Among Food Brands', 'cat' => 'Packaging'],
        ];

        $adminUser = User::where('role', 'admin')->first();
        foreach ($articleTitles as $idx => $data) {
            $cat = Category::where('name', $data['cat'])->where('type', 'article')->first();
            Article::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . time() . $idx,
                'excerpt' => 'This is a summary of the article about ' . $data['title'] . '. Industry experts weigh in on the latest developments.',
                'content' => '<p>The food and beverage industry continues to evolve rapidly, driven by changing consumer preferences, regulatory requirements, and technological innovations.</p><p>Industry analysts and leading manufacturers are closely watching these developments as they reshape the competitive landscape for companies of all sizes.</p><p>Key stakeholders from across the supply chain gathered recently to discuss the implications and opportunities presented by these changes.</p><h3>Key Findings</h3><p>The latest research indicates significant shifts in how companies approach production, packaging, and distribution. Several major players have already begun implementing new strategies to capitalize on emerging trends.</p><p>Experts predict continued growth in this segment over the coming years, with strong demand from both domestic and international markets.</p>',
                'category_id' => $cat?->id,
                'user_id' => $adminUser->id,
                'author_name' => 'Editorial Team',
                'status' => 'published',
                'is_featured' => $idx < 3,
                'views' => rand(100, 5000),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // Products
        $prodCat = Category::where('type', 'product')->first();
        $company = Company::first();
        $productNames = [
            'Natural Flavor Enhancer Pro', 'Organic Wheat Protein Isolate', 'Plant-Based Fat Replacer',
            'Premium Vanilla Extract', 'Beverage Stabilizer System', 'Clean Label Preservative',
        ];
        foreach ($productNames as $idx => $name) {
            Product::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . time() . $idx,
                'short_description' => 'High-quality ' . $name . ' for food and beverage applications.',
                'description' => '<p>A premium quality ingredient designed for modern food manufacturers seeking clean label solutions. This product meets all international food safety standards.</p><p>Features excellent solubility, stability, and functionality across a wide range of applications.</p>',
                'category_id' => $prodCat?->id,
                'company_id' => $company?->id,
                'status' => 'published',
                'is_featured' => $idx < 3,
            ]);
        }

        // Events
        $events = [
            ['title' => 'Food & Beverage Innovation Summit 2025', 'type' => 'conference', 'city' => 'Chicago', 'country' => 'USA', 'days' => 30],
            ['title' => 'Sustainable Packaging Webinar Series', 'type' => 'webinar', 'city' => 'Online', 'country' => 'Virtual', 'days' => 15],
            ['title' => 'International Food Technology Expo 2025', 'type' => 'tradeshow', 'city' => 'Frankfurt', 'country' => 'Germany', 'days' => 60],
            ['title' => 'Beverage Industry Conference Asia', 'type' => 'conference', 'city' => 'Singapore', 'country' => 'Singapore', 'days' => 45],
        ];

        foreach ($events as $idx => $data) {
            Event::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']) . '-' . time() . $idx,
                'short_description' => 'Join industry leaders at ' . $data['title'] . '.',
                'description' => '<p>This premier industry event brings together leading professionals from across the food and beverage sector for two days of networking, learning, and innovation.</p><p>Sessions will cover the latest trends, technologies, and regulatory developments shaping the industry.</p>',
                'event_type' => $data['type'],
                'start_date' => now()->addDays($data['days']),
                'end_date' => now()->addDays($data['days'] + 2),
                'city' => $data['city'],
                'country' => $data['country'],
                'status' => 'upcoming',
                'is_free' => $idx % 2 === 0,
                'price' => $idx % 2 === 0 ? 0 : 499.00,
                'is_featured' => true,
                'organizer' => 'Food Industry Association',
            ]);
        }

        echo "Database seeded successfully!\n";
        echo "Admin login: admin@foodindustry.com / admin123\n";
    }
}
