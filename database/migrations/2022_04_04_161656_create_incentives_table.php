<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncentivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incentives', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->string('username', 255);
            $table->decimal('amount', 10, 2);
            $table->decimal('deduction', 10, 2)->default(0);
            $table->decimal('net', 10, 2);
            $table->string('incentive_name', 255)->nullable();
            $table->string('incentive_for', 255)->nullable();
            $table->string('incentive_info', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incentives');
    }
}
