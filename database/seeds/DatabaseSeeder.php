<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Administratorius',
            'email' => 'administratorius@gmail.com',
            'password' => '$2y$10$wntG1GmD.nE9qVV2MA2hA.UWNcX3ZHtWySoazplOIbezrBrmkB4Pu',
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Vartotojas',
            'email' => 'vartotojas@gmail.com',
            'password' => '$2y$10$wntG1GmD.nE9qVV2MA2hA.UWNcX3ZHtWySoazplOIbezrBrmkB4Pu',
        ]);

        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'admin',
            'display_name' => 'Administrator'
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'user',
            'display_name' => 'User'
        ]);

        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1
        ], [
            'user_id' => 2,
            'role_id' => 2
        ]);
    }
}
