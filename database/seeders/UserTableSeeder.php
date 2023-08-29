<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users=[
            ['name'=>'Tuhin','email'=>'tuhin@gmail.com','password'=>'1234'],
            ['name'=>'susmita','email'=>'susmita@gmail.com','password'=>'12345'],
            ['name'=>'tanha','email'=>'tanha@gmail.com','password'=>'123456'],
        ];
        User::insert($users);
    }
}
