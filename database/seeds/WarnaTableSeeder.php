<?php

use Illuminate\Database\Seeder;

class WarnaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warna')->insert([
    		[
                'nama' => 'merah',
                'value' => '#bb0020'
            ],
    		[
                'nama' => 'biru',
                'value' => '#00a1ff'
            ],
    		[
                'nama' => 'ungu',
                'value' => '#5400ff'
            ],
    		[
                'nama' => 'putih',
                'value' => '#ffffff'
            ],
    		[
                'nama' => 'hijau',
                'value' => '#00c745'
            ],
    		[
                'nama' => 'kuning',
                'value' => '#ffd800'
            ]
    	]);
    }
}
