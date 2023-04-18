<?php

use Illuminate\Database\Seeder;

class OrderDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('order_detail')->insert([
    		[
    			'order_id' => 1,
    			'produk_id' => 1,
    			'jumlah' => '1',
    			'harga' => '130000',
    			'keterangan' => NULL
    		],
            [
                'order_id' => 1,
                'produk_id' => 2,
                'jumlah' => '1',
                'harga' => '150000',
                'keterangan' => NULL
            ]
    	]);
    }
}
