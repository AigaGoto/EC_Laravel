<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Product::class, 2) //Postモデルを参照して尚且つ50個のダミーデータを作成
            ->create();
    }
}
