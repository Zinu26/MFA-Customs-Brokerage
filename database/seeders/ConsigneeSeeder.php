<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsigneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $file = public_path('csv/consignees.sql');
        $sql = file_get_contents($file);
        DB::unprepared($sql);
    }
}
