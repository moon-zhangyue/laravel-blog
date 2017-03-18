<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name'=>'我的博客',
                'link_title'=>'laravel试炼',
                'link_url'=>'www.1024.com',
                'link_order'=>1,
            ],
            [
                'link_name'=>'1024',
                'link_title'=>'天天更新',
                'link_url'=>'www.1024.com',
                'link_order'=>2,
            ],
        ];
        DB::table('links')->insert($data);
    }
}
