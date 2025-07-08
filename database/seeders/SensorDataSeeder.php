<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SensorDataSeeder extends Seeder
{
    public function run()
    {
        $startTime = Carbon::now()->subDays(5)->startOfDay(); // <-- perbaikan waktu mulai
        $endTime = Carbon::now()->endOfDay(); // <-- perbaikan waktu akhir
        $currentTime = $startTime->copy();

        $data = [];

        $temperature = 29.5;
        $humidity = 80.5;
        $count = 0;
        while ($currentTime <= $endTime) {
            
            $this->command->info($currentTime <= $endTime);
            // Fluktuasi kecil
            $this->command->info("Input lagi...");
            $temperature += mt_rand(-5, 5) / 10;
            $humidity += mt_rand(-5, 5) / 10;

            // Clamp nilai ke dalam batas
            $temperature = max(27.2, min(32.2, $temperature));
            $humidity = max(78, min(83, $humidity));

            $data[] = [
                'temperature' => round($temperature, 4),
                'humadity' => round($humidity, 4),
                'relay_state' => ['on', 'off'][rand(0, 1)],
                'created_at' => $currentTime->copy(),
                'updated_at' => $currentTime->copy(),
            ];

            $currentTime->addSeconds(2);
            $count++;

            // Insert per 1000
            if (count($data) >= 1000) {
                DB::table('sensor_data')->insert($data);
                $data = [];
            }
        }

        // Insert sisa
        if (count($data)) {
            DB::table('sensor_data')->insert($data);
        }

        $this->command->info("Total data generated: $count");
    }
}