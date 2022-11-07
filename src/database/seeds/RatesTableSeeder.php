<?php

use Illuminate\Database\Seeder;

class RatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Rate::class, 20) //Postモデルを参照して尚且つ50個のダミーデータを作成
            ->create();
    }
}
