<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableSites extends Migration
{
    private $table = "sites";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->autoIncrement();
            $table->smallInteger("category_id")->nullable(false)->comment("分类id");
            $table->string("title", 255)->nullable(false)->comment("标题");
            $table->string("thumb", 255)->nullable(false)->comment('缩略图');
            $table->string('describe', 255)->nullable(false)->comment('描述');
            $table->string('url', 255)->nullable(false)->comment('跳转地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
