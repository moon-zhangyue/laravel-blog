<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('link_id');
            $table->string('link_name')->default('')->comment('//友情链接名称');
            $table->string('link_title')->default('')->comment('//友情链接标题');
            $table->string('link_url')->default('')->comment('//友情链接链接');
            $table->integer('link_order')->default(0)->comment('//友情链接排序');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('links');
    }
}
