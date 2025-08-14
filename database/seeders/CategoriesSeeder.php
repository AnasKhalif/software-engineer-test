<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use MongoDB\Laravel\Eloquent\Model;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Books',
            'Home & Kitchen',
            'Toys & Games',
            'Sports & Outdoors',
            'Beauty & Personal Care',
            'Automotive',
            'Health & Wellness',
            'Office Supplies'
        ];

        foreach ($categories as $category) {
            DB::connection('mongodb')->table('categories')->insert([
                'name' => $category,
                'slug' => Str::slug($category),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
