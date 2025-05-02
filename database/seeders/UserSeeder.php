<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    User::create([
        'name' => 'admin',
        'email' => 'adtekmt@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'staff keuangan'
    ]);

    User::create([
        'name' => 'Nadia',
        'email' => 'nadia.salsabila261004@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'staff umum'
    ]);
}
}
