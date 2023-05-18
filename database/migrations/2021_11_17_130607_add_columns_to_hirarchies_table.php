<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToHirarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hirarchies', function (Blueprint $table) {
            $table->decimal('total_income', 10, 2)->default(0);
            $table->decimal('todays_income', 10, 2)->default(0);
            $table->string('position_1')->nullable();
            $table->string('position_2')->nullable();
            $table->string('position_3')->nullable();
            $table->string('position_4')->nullable();
            $table->string('position_5')->nullable();
            $table->boolean('income')->default(0)->comment('1: yes, 0: no');
            $table->decimal('wallet_1', 10, 2)->default(0);
            $table->decimal('wallet_2', 10, 2)->default(0);
            $table->decimal('retopup', 10, 2)->default(0);
            $table->decimal('income_1', 10, 2)->default(0);
            $table->decimal('income_2', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hirarchies', function (Blueprint $table) {
            $table->dropColumn(['total_income',  'todays_income', 'position_2', 'position_3', 'position_4', 'position_5', 'income', 'wallet_1', 'wallet_2', 'retopup', 'income_1', 'income_2']);
        });
    }
}
