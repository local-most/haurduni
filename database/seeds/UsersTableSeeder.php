<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nama' => 'admin',
                'username' => 'admin',
                'password' => bcrypt('123'),
                'role' => '1',
                'validate' => '1',
                'foto' => NULL,
                'nohp' => NULL,
                'email' => NULL,
                'wilayah_id' => null,
                'alamat' => null,
            ],
            [
                'nama' => 'Owner Haurduni Motor',
                'username' => 'owner',
                'password' => bcrypt('123'),
                'role' => '3',
                'validate' => '1',
                'foto' => NULL,
                'nohp' => NULL,
                'email' => NULL,
                'wilayah_id' => null,
                'alamat' => null,
            ],
            [
                'nama' => 'Dzul',
                'username' => 'dzul',
                'password' => bcrypt('1234'),
                'role' => '2',
                'wilayah_id' => 1,
                'foto' => NULL,
                'nohp' => '082122900981',
                'email' => 'zul@gmail.com',
                'alamat' => 'Desa Cigadung',
                'validate' => '1'
            ]
        ]);
    }
}
