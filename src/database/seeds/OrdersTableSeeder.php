<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Order::class, 2) //Postモデルを参照して尚且つ50個のダミーデータを作成
            ->create();
    }
}
