<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Account extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('name')->nullable(false);
            $table->decimal('balance', 10, 2)->nullable(false);
            $table->decimal('target', 10, 2)->nullable(false);
            $table->string('description')->nullable(true);
            $table->dateTime('updated_at', $precision = 0);
            $table->dateTime('created_at', $precision = 0);

//            $table->primary(['id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('account');
    }
}
