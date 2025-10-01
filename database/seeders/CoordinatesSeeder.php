<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CoordinatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = base_path('cordinates.csv');

        if (!File::exists($csvFile)) {
            $this->command->error('CSV file not found: ' . $csvFile);
            return;
        }

        $handle = fopen($csvFile, 'r');

        // Skip header row
        fgetcsv($handle);

        $coordinates = [];

        while (($data = fgetcsv($handle)) !== false) {
            if (count($data) >= 2 && !empty($data[0]) && !empty($data[1])) {
                $locationName = trim($data[0]);
                $coordinateString = trim($data[1]);

                // Parse coordinate string like "N9 38.060 E39 15.780"
                $latitude = $this->parseCoordinate($coordinateString, 'latitude');
                $longitude = $this->parseCoordinate($coordinateString, 'longitude');

                $coordinates[] = [
                    'location_name' => $locationName,
                    'coordinate' => $coordinateString,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'is_active' => true,
                    'created_by' => 1, // Default system user
                    'updated_by' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        fclose($handle);

        // Insert in chunks to avoid memory issues
        collect($coordinates)->chunk(50)->each(function ($chunk) {
            DB::table('coordinates')->insert($chunk->toArray());
        });

        $this->command->info('Imported ' . count($coordinates) . ' coordinates successfully.');
    }

    /**
     * Parse coordinate string to decimal degrees
     */
    private function parseCoordinate($coordinateString, $type)
    {
        // Example: "N9 38.060 E39 15.780" or "S7 18.845 E72 24.660"
        $pattern = '/([NS])(\d+)\s+([\d.]+)\s+([EW])(\d+)\s+([\d.]+)/';

        if (preg_match($pattern, $coordinateString, $matches)) {
            if ($type === 'latitude') {
                $degrees = (float)$matches[2];
                $minutes = (float)$matches[3];
                $decimal = $degrees + ($minutes / 60);
                return $matches[1] === 'S' ? -$decimal : $decimal;
            } elseif ($type === 'longitude') {
                $degrees = (float)$matches[5];
                $minutes = (float)$matches[6];
                $decimal = $degrees + ($minutes / 60);
                return $matches[4] === 'W' ? -$decimal : $decimal;
            }
        }

        return null;
    }
}
