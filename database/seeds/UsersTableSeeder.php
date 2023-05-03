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
                'ktp' => NULL,
                'wilayah_id' => null,
                'alamat' => null,
            ],
            [
                'nama' => 'Pimpinan',
                'username' => 'pimpinan',
                'password' => bcrypt('123'),
                'role' => '3',
                'validate' => '1',
                'foto' => NULL,
                'nohp' => NULL,
                'ktp' => NULL,
                'wilayah_id' => null,
                'alamat' => null,
            ],
            [
                'nama' => 'Dzul',
                'username' => 'dzul',
                'password' => bcrypt('1234'),
                'role' => '2',
                'wilayah_id' => 3,
                'foto' => NULL,
                'nohp' => NULL,
                'ktp' => NULL,
                'alamat' => 'Desa Cigadung',
                'validate' => '1'
            ]
        ]);
    }
}
