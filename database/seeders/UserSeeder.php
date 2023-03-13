<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate User
        User::truncate();

        //hash password
        $hashPass = Hash::make('password');

        //Seed Author User
        $user = User::factory()->create([
            'first_name' => 'Trust',
            'last_name' => 'Edoyugbo',
            'email' => 'trust.edoyugbo@yahoo.com',
            'password' => $hashPass
        ]);

        //Create 5 Default Users with factory
        $users = User::factory()->count(5)->create();
    }
}
