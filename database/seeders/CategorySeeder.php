<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 30; $i++) {
            DB::table('categories')->insert([
                'name' => 'Category ' . $i,
                'slug' => Str::slug('Category ' . $i),
                'active' => rand(0, 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
