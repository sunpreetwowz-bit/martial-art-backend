<?php

namespace Database\Seeders;

use App\Models\BeltLevel;
use Illuminate\Database\Seeder;

class BeltLevelSeeder extends Seeder
{
    public function run()
    {
        $belts = [
            ['name' => 'White', 'color' => '#FFFFFF', 'order' => 1],
            ['name' => 'Yellow', 'color' => '#FFD700', 'order' => 2],
            ['name' => 'Orange', 'color' => '#FF8C00', 'order' => 3],
            ['name' => 'Green', 'color' => '#228B22', 'order' => 4],
            ['name' => 'Blue', 'color' => '#1E90FF', 'order' => 5],
            ['name' => 'Brown', 'color' => '#8B4513', 'order' => 6],
            ['name' => 'Black', 'color' => '#000000', 'order' => 7],
        ];
        foreach ($belts as $belt) {
            BeltLevel::firstOrCreate(['name' => $belt['name']], $belt);
        }
    }
}
