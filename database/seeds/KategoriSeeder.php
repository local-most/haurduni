<?php

use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('kategori')->insert([
    		[
    			'nama' => 'Roofrack',
                'is_color' => false,
                'harga' => 0,
    		],
    		[
    			'nama' => 'Oli Mobil',
                'is_color' => false,
                'harga' => 0,
    		],
            [
                'nama' => 'Towing Bar',
                'is_color' => false,
                'harga' => 0,
            ],
            [
                'nama' => 'Garnish',
                'is_color' => false,
                'harga' => 0,
            ],
            [
                'nama' => 'Bumper (Tanduk)',
                'is_color' => false,
                'harga' => 0,
            ],
            [
                'nama' => 'Aksesoris',
                'is_color' => false,
                'harga' => 0,
            ],
    	]);
    }
}
