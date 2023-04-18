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
    			'nama' => 'Corsa Do1 Ukuran 50/90-17',
    			'kategori_id' => 1,
                'satuan_id' => 2,
    			'harga' => '130000',
    			'stok' => '1000',
                'foto' => '/images/products/ban-corsa.jpeg',
    			'berat' => '150',
    			'deskripsi' => 'Isi Deskripsi'
    		],
            [
                'nama' => 'Primaax Sk Ukuran 01 60/80-17',
                'kategori_id' => 1,
                'satuan_id' => 2,
                'harga' => '150000',
                'stok' => '1000',
                'foto' => '/images/products/ban-primaxx.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'IRC SS-560F Ukuran 100/80-14',
                'kategori_id' => 1,
                'satuan_id' => 2,
                'harga' => '196000',
                'stok' => '1000',
                'foto' => '/images/products/ban-irc.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'FDR Genzi Pro Ukuran 80/80-14',
                'kategori_id' => 1,
                'satuan_id' => 2,
                'harga' => '235000',
                'stok' => '1000',
                'foto' => '/images/products/ban-fdr-genzi.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'MIZZLE MR-01 Ukuran 90/80-17',
                'kategori_id' => 1,
                'satuan_id' => 2,
                'harga' => '325000',
                'stok' => '1000',
                'foto' => '/images/products/ban-mizzle.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            // Kategori Oli [2]
            [
                'nama' => 'Yamalube Sport 1L',
                'kategori_id' => 2,
                'satuan_id' => 2,
                'harga' => '52000',
                'stok' => '1000',
                'foto' => '/images/products/oli-yamalube.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'AHM Mpx2 800ml',
                'kategori_id' => 2,
                'satuan_id' => 2,
                'harga' => '48000',
                'stok' => '1000',
                'foto' => '/images/products/ahm-mpx2.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'Evalube 2T 700ml',
                'kategori_id' => 2,
                'satuan_id' => 2,
                'harga' => '23000',
                'stok' => '1000',
                'foto' => '/images/products/evalube-2T.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            // Kategori Aki [3]
            [
                'nama' => 'GS Aki Kering GTZ5S',
                'kategori_id' => 3,
                'satuan_id' => 2,
                'harga' => '300000',
                'stok' => '1000',
                'foto' => '/images/products/gs-gtz5s.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'YUASA Aki Kering YTZ5S',
                'kategori_id' => 3,
                'satuan_id' => 2,
                'harga' => '200000',
                'stok' => '1000',
                'foto' => '/images/products/yuasa-ytz5s.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'MOTOBATT Aki Kering',
                'kategori_id' => 3,
                'satuan_id' => 2,
                'harga' => '160000',
                'stok' => '1000',
                'foto' => '/images/products/motobat.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            // Kategori Kampas Rem [4]
            [
                'nama' => 'Honda kampas Rem depan Matic',
                'kategori_id' => 4,
                'satuan_id' => 2,
                'harga' => '15000',
                'stok' => '1000',
                'foto' => '/images/products/kampas-rem-depan.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'Honda kampas rem belakang trombol motor bebek',
                'kategori_id' => 4,
                'satuan_id' => 2,
                'harga' => '35000',
                'stok' => '1000',
                'foto' => '/images/products/kampas-trombol.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'YAMAHA kampas rem depan motor gede',
                'kategori_id' => 4,
                'satuan_id' => 2,
                'harga' => '30000',
                'stok' => '1000',
                'foto' => '/images/products/kampas-rem-depan-yamaha.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            // Kategori Body Motor [5]
            [
                'nama' => 'AHM Spakbor depan Beat Warna Biru',
                'kategori_id' => 5,
                'satuan_id' => 2,
                'harga' => '80000',
                'stok' => '1000',
                'foto' => '/images/products/spakbor-depan-beat.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'Body Belakang Beat esp 2016 Hitam',
                'kategori_id' => 5,
                'satuan_id' => 2,
                'harga' => '164000',
                'stok' => '1000',
                'foto' => '/images/products/body-belakang-beat-esp-2016.png',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
            [
                'nama' => 'Cover Bagian Honda Beat',
                'kategori_id' => 5,
                'satuan_id' => 2,
                'harga' => '80000',
                'stok' => '1000',
                'foto' => '/images/products/cover-honda-beat.jpeg',
                'berat' => '150',
                'deskripsi' => 'Isi Deskripsi'
            ],
    	]);
    }
}
