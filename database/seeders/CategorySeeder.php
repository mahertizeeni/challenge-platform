<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   $categories = ['التاريخ','المعلومات العامة', 'العلوم والطبيعة','رياضة','جغرافيا','فن'];

        foreach ($categories as $category) {
            Category::Create([
                'name' => $category,
            ]);
        }
    }
}
