<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SearchHistory;
use App\Models\UserPreference;
use App\Models\User;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        // Create test user preferences
        $users = User::where('role', 'user')->take(3)->get();

        foreach ($users as $user) {
            // Create user preference
            UserPreference::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'health_condition' => $this->getRandomHealthCondition(),
                    'preferred_categories' => $this->getRandomCategories(),
                    'min_price' => rand(10000, 50000),
                    'max_price' => rand(100000, 500000),
                    'allergic_ingredients' => $this->getRandomIngredients(),
                    'weight_kandungan' => round(rand(20, 40) / 100, 2),
                    'weight_khasiat' => round(rand(25, 35) / 100, 2),
                    'weight_harga' => round(rand(15, 25) / 100, 2),
                    'weight_expired' => round(rand(20, 30) / 100, 2),
                ]
            );

            // Ensure weights sum to 1.0
            $preference = $user->preference;
            $total = $preference->weight_kandungan + $preference->weight_khasiat +
                $preference->weight_harga + $preference->weight_expired;

            $preference->update([
                'weight_kandungan' => round($preference->weight_kandungan / $total, 2),
                'weight_khasiat' => round($preference->weight_khasiat / $total, 2),
                'weight_harga' => round($preference->weight_harga / $total, 2),
                'weight_expired' => round(1 - ($preference->weight_kandungan / $total +
                    $preference->weight_khasiat / $total +
                    $preference->weight_harga / $total), 2),
            ]);

            // Create search histories
            for ($i = 0; $i < rand(3, 8); $i++) {
                SearchHistory::create([
                    'user_id' => $user->id,
                    'search_query' => $this->getRandomSearchQuery(),
                    'criteria_weights' => [
                        'kandungan' => round(rand(20, 40) / 100, 2),
                        'khasiat' => round(rand(25, 35) / 100, 2),
                        'harga' => round(rand(15, 25) / 100, 2),
                        'expired' => round(rand(20, 30) / 100, 2),
                    ],
                    'filters_applied' => [
                        'category' => $this->getRandomCategory(),
                        'max_price' => $this->getRandomMaxPrice(),
                    ],
                    'results' => $this->generateFakeResults(),
                    'created_at' => Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23)),
                ]);
            }
        }
    }

    private function getRandomHealthCondition()
    {
        $conditions = [
            'Diabetes mellitus',
            'Hipertensi',
            'Kolesterol tinggi',
            'Asam urat',
            'Gastritis',
            'Insomnia',
            'Stress dan kecemasan',
            'Stamina dan vitalitas',
            'Sistem imun lemah',
            'Gangguan pencernaan'
        ];

        return $conditions[array_rand($conditions)];
    }

    private function getRandomCategories()
    {
        $categories = ['Tradisional', 'Modern', 'Herbal Murni', 'Campuran'];
        return [array_rand(array_flip($categories))];
    }

    private function getRandomCategory()
    {
        $categories = ['Tradisional', 'Modern', 'Herbal Murni', 'Campuran', ''];
        return $categories[array_rand($categories)];
    }

    private function getRandomIngredients()
    {
        $ingredients = ['Jahe', 'Kunyit', 'Temulawak', 'Kencur', 'Serai', 'Pandan'];
        $selected = array_rand(array_flip($ingredients), rand(1, 3));
        return is_array($selected) ? $selected : [$selected];
    }

    private function getRandomSearchQuery()
    {
        $queries = [
            'diabetes',
            'hipertensi',
            'kolesterol',
            'asam urat',
            'stamina',
            'pencernaan',
            'flu batuk',
            'pegal linu',
            'insomnia',
            'stress',
            ''
        ];

        return $queries[array_rand($queries)];
    }

    private function getRandomMaxPrice()
    {
        $prices = ['', '50000', '100000', '200000', '500000'];
        return $prices[array_rand($prices)];
    }

    private function generateFakeResults()
    {
        $results = [];
        for ($i = 0; $i < rand(5, 10); $i++) {
            $results[] = [
                'id' => rand(1, 20),
                'nama' => 'Jamu ' . ['Kunyit Asam', 'Beras Kencur', 'Temulawak', 'Jahe Merah', 'Kencur Asam'][array_rand(['Kunyit Asam', 'Beras Kencur', 'Temulawak', 'Jahe Merah', 'Kencur Asam'])],
                'kategori' => ['Tradisional', 'Modern', 'Herbal Murni'][array_rand(['Tradisional', 'Modern', 'Herbal Murni'])],
                'harga' => rand(25000, 150000),
                'score' => round(rand(70, 95) / 100, 3),
                'khasiat' => 'Untuk kesehatan dan stamina',
                'kandungan' => 'Herbal alami pilihan'
            ];
        }

        // Sort by score desc
        usort($results, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return $results;
    }
}
