<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    public function run(): void
    {
        
        DB::table('users')->delete(); 
       
        
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin',
            'password' => Hash::make('123123123'),
            'role' => 'admin'
        ]);

        User::factory(7)->create();
    }
}

