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
    			'nama' => 'Kategori Ban',
                'is_color' => false,
                'harga' => 0,
    		],
    		[
    			'nama' => 'Kategori Oli',
                'is_color' => false,
                'harga' => 0,
    		],
            [
                'nama' => 'Kategori Aki',
                'is_color' => false,
                'harga' => 0,
            ],
            [
                'nama' => 'Kategori Kampas Rem',
                'is_color' => false,
                'harga' => 0,
            ],
            [
                'nama' => 'Kategori Body Motor',
                'is_color' => false,
                'harga' => 0,
            ],
    	]);
    }
}
