<?php

use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('produk')->insert([
            // Kategori Ban [1]
    		[
                'nama'=>'Roofrack Jazz/Brio/Ayla',
                'kategori_id'=>1,
                'satuan_id'=>3,
                'harga'=>'125000',
                'berat'=>'5',
                'deskripsi'=>'
                Roofrack adalah part penting untuk mobil guna memberikan space lebih untuk membawa barang dibagian atas mobil. Dengan desain dan bahan yang kuat Roofrack mampu mengikat barang banyak untuk dibawa berpergian jauh dengan aman dan nyaman.',
                'foto'=>'images/products/foto1-6451f4fc6ba60.jpg',
                'warna_id'=>NULL,
                'stok'=>14,
                'created_at'=>'2023-05-03 05:26:46',
                'updated_at'=>'2023-05-03 05:45:32',
                'deleted_at'=>NULL
    		],
            [
                'nama'=>'Roofrack Avanza/Xenia',
                'kategori_id'=>1,
                'satuan_id'=>3,
                'harga'=>'350000',
                'berat'=>'5',
                'deskripsi'=>'
                Roofrack adalah part penting untuk mobil guna memberikan space lebih untuk membawa barang dibagian atas mobil. Dengan desain dan bahan yang kuat Roofrack mampu mengikat barang banyak untuk dibawa berpergian jauh dengan aman dan nyaman.',
                'foto'=>'images/products/foto1-6451f4ba98c86.jpg',
                'warna_id'=>NULL,
                'stok'=>10,
                'created_at'=>'2023-05-03 05:44:26',
                'updated_at'=>'2023-05-03 05:44:26',
                'deleted_at'=>NULL
            ],
            [
                'nama'=>'Garnish Sign Lamp Avanza/Xenia 19 Chrome',
                'kategori_id'=>4,
                'satuan_id'=>2,
                'harga'=>'60000',
                'berat'=>'1',
                'deskripsi'=>'
                Mempecantik dan estetik sebuah lampu mobil anda dengan Garnish Chrome yang bagus dan elegan.',
                'foto'=>'images/products/foto1-6451f5d423511.jpg',
                'warna_id'=>NULL,
                'stok'=>99,
                'created_at'=>'2023-05-03 05:49:08',
                'updated_at'=>'2023-05-03 05:49:08',
                'deleted_at'=>NULL
            ],
            [
                'nama'=>'Garnish Tail Lamp Avanza/Xenia 19 Chrome',
                'kategori_id'=>4,
                'satuan_id'=>2,
                'harga'=>'50000',
                'berat'=>'1',
                'deskripsi'=>'
                Garnish Lampu belakang guna mempercantik dan elegan lampu bagian belakang, dengan warna Chrome.',
                'foto'=>'images/products/foto1-6451f63b5e76c.jpg',
                'warna_id'=>NULL,
                'stok'=>99,
                'created_at'=>'2023-05-03 05:50:51',
                'updated_at'=>'2023-05-03 05:53:59',
                'deleted_at'=>NULL
            ],
            [
                'nama'=>'Garnish Tail Lamp Rush/Terios Blacktivo',
                'kategori_id'=>4,
                'satuan_id'=>2,
                'harga'=>'50000',
                'berat'=>'1',
                'deskripsi'=>'
                Mempecantik dan estetik sebuah lampu mobil anda dengan Garnish Warna hitam yang bagus dan elegan.',
                'foto'=>'images/products/foto1-6451f6ec61bb0.jpg',
                'warna_id'=>NULL,
                'stok'=>99,
                'created_at'=>'2023-05-03 05:53:48',
                'updated_at'=>'2023-05-03 05:53:48',
                'deleted_at'=>NULL
            ],
    	]);
    }
}
