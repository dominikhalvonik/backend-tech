<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('address', function (Blueprint $table) {
            $table->foreign("user_id", "fk_user_address_key")->references('id')->on('user');
        });

        Schema::table('phone', function (Blueprint $table) {
            $table->foreign("user_id", "fk_user_phone_key")->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('address', function (Blueprint $table) {
            $table->dropForeign("fk_user_address_key");
        });

        Schema::table('phone', function (Blueprint $table) {
            $table->dropForeign("fk_user_phone_key");
        });
    }
};
