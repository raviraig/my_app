<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTablerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'id' => 1,
                'first_name' => 'user',
                'last_name' => 'two',
                'password' => '$2y$10$DgF0m1JnI/qW9DPy9l5qJeCPs/b1j7Ahczgmj7Tohc56xk8/Pz2pa',
                'created_at' => '2021-05-23 10:59:26',
                'updated_at' => '2021-05-23 10:59:26',
                'role' => 1
            ]
        ];

         User::insert($user);
    }
}
