<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CampBenefit;
class CampBenefitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $campBenefits = [
            [
                'camp_id' => 1,
                'name' => 'Pro Techstack kit',
            ],
            [
                'camp_id' => 1,
                'name' => 'iMac pro 2021 & Display',
            ],
            [
                'camp_id' => 1,
                'name' => '1-1 Mentoring Program',
            ],
            [
                'camp_id' => 1,
                'name' => 'Final Project Certificate',
            ],
            [
                'camp_id' => 1,
                'name' => 'Offline Course Video',
            ],
            [
                'camp_id' => 1,
                'name' => 'Future Job Opportunity',
            ],
            [
                'camp_id' => 1,
                'name' => 'Premium Design Kit',
            ],
            [
                'camp_id' => 1,
                'name' => 'Website Builder',
            ],
            [
                'camp_id' => 2,
                'name' => '1-1 Mentoring Program',
            ],
            [
                'camp_id' => 2,
                'name' => 'Final Project Certificate',
            ],
            [
                'camp_id' => 2,
                'name' => 'Offline Course Video',
            ],
        ];

        CampBenefit::insert($campBenefits);
    }
}
