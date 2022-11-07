<?php

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Review::class, 10) //Postモデルを参照して尚且つ50個のダミーデータを作成
            ->create();
    }
}
