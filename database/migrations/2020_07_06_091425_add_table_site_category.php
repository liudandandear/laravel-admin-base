<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableSiteCategory extends Migration
{
    private $table = "site_category";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->smallIncrements('id')->autoIncrement();
            $table->smallInteger("parent_id")->nullable(false)->comment("上级id")->default(0);
            $table->smallInteger("order")->nullable(false)->comment("排序")->default(0);
            $table->string("title")->bullable(false)->comment("标题");
            $table->string("icon")->nullable(false)->comment("图标")->default("");
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
