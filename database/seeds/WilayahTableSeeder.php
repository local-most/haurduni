<?php

use Illuminate\Database\Seeder;

class WilayahTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('wilayah')->insert([
        	[
        		'nama' => 'Kuningan',
        		'ongkir' => '20000',
        	],
        	[
        		'nama' => 'Cirebon',
        		'ongkir' => '40000',
        	],
        	[
        		'nama' => 'Majalengka',
        		'ongkir' => '40000',
        	]
        ]);
    }
}
