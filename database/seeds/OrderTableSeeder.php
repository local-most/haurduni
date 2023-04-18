<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('order')->insert([
    		[
    			'user_id' => 3,
                'tanggal' => '2022-05-14 08:20:00',
    			'total_harga' => '280000',
    			'keterangan' => 'Pesanan ditunggu kak',
    			'status' => '1',
                'is_delivered' => false,
                'wilayah_id' => 1,
    			'bukti_pembayaran' => '',
    		],
    	]);
    }
}
