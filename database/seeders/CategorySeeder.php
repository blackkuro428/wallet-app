<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 収入（type=0）
        Category::create(['user_id' => null, 'type' => 0, 'name' => '給料']);
        Category::create(['user_id' => null, 'type' => 0, 'name' => 'ボーナス']);
        Category::create(['user_id' => null, 'type' => 0, 'name' => '返金']);
        Category::create(['user_id' => null, 'type' => 0, 'name' => 'その他']);

        // 支出（type=1）
        Category::create(['user_id' => null, 'type' => 1, 'name' => '家賃']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '食費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '日用品']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '光熱費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '経費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '通信費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '通院費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '旅費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => '娯楽費']);
        Category::create(['user_id' => null, 'type' => 1, 'name' => 'その他']);
    }
}
