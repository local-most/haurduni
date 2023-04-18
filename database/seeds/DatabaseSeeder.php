<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WilayahTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SatuanTableSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(ProdukSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(OrderDetailTableSeeder::class);
        $this->call(WarnaTableSeeder::class);
        $this->call(FeaturesTableSeeder::class);
    }
}
