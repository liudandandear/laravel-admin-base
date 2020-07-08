<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldAdminPermissions extends Migration
{
    private $table = 'admin_permissions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->integer("order")->after('http_path')->nullable(false)->default(0)->comment("排序");
            $table->integer("parent_id")->after('http_path')->nullable(false)->default(0)->comment("上级");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn("google2fa_secret");
            $table->dropColumn("recovery_code");
            $table->dropColumn("enable");
        });
    }
}
