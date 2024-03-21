<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      User::create([
        'first_name' => 'Hardik',
        'last_name' => 'Chauhan',
        'email' => 'hardik@gmail.com',
        'phone_number' => '9900332255',
        'address' =>  'Mumbai, India',
        'password' => bcrypt('123456'),
        'is_active'=> true,
    ]);
    }
}
