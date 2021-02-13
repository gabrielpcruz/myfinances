<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->id()->unsigned();

            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')
                ->references('id')->on('account');

            $table->dateTime('date')->nullable(false);
            $table->decimal('value', 10, 2)->nullable(false);
            $table->string('description')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction');
    }
}
