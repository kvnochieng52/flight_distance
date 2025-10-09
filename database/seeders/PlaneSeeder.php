<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plane;

class PlaneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $planes = [
            [
                'name' => 'CARAVAN',
                'model' => 'CESSNA C208',
                'capacity' => '1MT',
                'speed' => 140
            ],
            [
                'name' => 'CARAVAN',
                'model' => 'LET 410',
                'capacity' => '2MT',
                'speed' => 160
            ]
        ];

        foreach ($planes as $plane) {
            Plane::create($plane);
        }
    }
}
