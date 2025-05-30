<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReviewTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Schema::disableForeignKeyConstraints();  
        DB::table('reviews')->truncate();            
        Schema::enableForeignKeyConstraints();
        Review ::factory(22)->create();
  

    }
}
