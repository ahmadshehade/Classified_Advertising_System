<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Schema::disableForeignKeyConstraints();  
        DB::table('ads')->truncate();            
        Schema::enableForeignKeyConstraints(); 
        Ad::factory(20)->create();
    }
}
