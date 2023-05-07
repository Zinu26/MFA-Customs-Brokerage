<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CloseShipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $file = public_path('csv/dataset(1).sql');
        $sql = file_get_contents($file);
        DB::unprepared($sql);
    }
}
