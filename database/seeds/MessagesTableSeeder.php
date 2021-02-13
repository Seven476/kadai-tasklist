<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tasks')->insert([
            'status' => '完了',
            'content' => 'test content 1'
        ]);
        DB::table('tasks')->insert([
            'status' => '未完',
            'content' => 'test content 2'
        ]);
        DB::table('tasks')->insert([
            'status' => '完了',
            'content' => 'test content 3'
        ]);
    }
}
