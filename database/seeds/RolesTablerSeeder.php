<?php

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RolesTablerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id'=>1,
                'title'=>'Super Admin'
            ],
            [
                'id'=>2,
                'title'=>'Admin'
            ],
            [
                'id'=>3,
                'title'=>'Sales'
            ]
        ];

        Roles::insert($roles);
    }
}
