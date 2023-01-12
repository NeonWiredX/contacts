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
        Schema::table('contacts', function (Blueprint $table) {
        $table->index('firstname');
        $table->index('lastname');
        $table->index('patrony');
        $table->index('email');
        $table->index('phone');
        });

        Schema::table('tags', function (Blueprint $table) {
        $table->index('text');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
