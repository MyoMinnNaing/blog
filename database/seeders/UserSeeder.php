<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->create([
            "name" => "poe lay",
            "email" => "poe@gmail.com",
            "password" => Hash::make("asdffdsa"),
        ]);

        User::factory(100)->create();

        User::factory()->create([
            "name" => "myo min naing",
            "email" => "myominnaing.eng@gmail.com",
            "password" => Hash::make("asdffdsa"),
            "role" => "admin"
        ]);
    }
}
