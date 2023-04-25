<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Employee;

class CreateUsersSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'=>'Admin',
                'username'=>'Admin',
                'type'=>0,
                'email_verified_at'=> now(),
                'password'=> bcrypt('password'),
             ],[
                'name'=>'User',
                'username'=>'User',
                'type'=>1,
                'email_verified_at'=> now(),
                'password'=> bcrypt('password'),
             ],
        ];

        foreach ($users as $key => $user) {
            if($user['type'] == 1){
                $newUser = User::create($user);

                $employee = new Employee;
                $employee->user_id = $newUser->id;
                $employee->position = 'position';
                $employee->birthdate = now();
                $employee->contact_number = '123456789';
                $employee->email = 'user@example.com';
                $employee->save();
            }
            else{
                User::create($user);
            }
        }
    }
}
