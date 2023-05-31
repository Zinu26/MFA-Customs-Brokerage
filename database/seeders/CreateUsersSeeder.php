<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employee;
use App\Models\Consignee;

class CreateUsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'Admin',
                'email' => 'admin@admin.com',
                'type' => 0,
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ], [
                'name' => 'User',
                'username' => 'User',
                'email' => 'user@user.com',
                'type' => 1,
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $key => $user) {
            if ($user['type'] == 1) {
                $newUser = User::create($user);

                $employee = new Employee;
                $employee->user_id = $newUser->id;
                $employee->position = 'position';
                $employee->birthdate = now();
                $employee->contact_number = '123456789';
                $employee->save();
            } else {
                User::create($user);
            }
        }

        // $file = public_path('csv/users.sql');
        // $sql = file_get_contents($file);
        // DB::unprepared($sql);
    }
}
