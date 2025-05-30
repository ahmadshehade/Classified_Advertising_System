<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();  
       DB::table('categories')->truncate();        
        Schema::enableForeignKeyConstraints();
        $categories = [
            'Real Estate',
            'Cars',
            'Jobs',
            'Electronics',
            'Home & Furniture',
            'Services',
            'Fashion',
            'Animals',
            'Books',
            'Others',
        ];

        foreach ($categories as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name) . '-' . uniqid()
            ]);
        }
       
        Category::factory(15)->create();
    
    }
}
