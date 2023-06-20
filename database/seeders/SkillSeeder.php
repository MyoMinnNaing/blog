<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = ['html', 'css', 'js', 'php'];

        $arr = [];
        foreach ($skills as $skill) {
            $arr[] = [
                "title" => $skill
            ];
        }

        Skill::insert($arr);
    }
}
