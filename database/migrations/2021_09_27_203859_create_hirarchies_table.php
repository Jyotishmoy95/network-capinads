<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHirarchiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hirarchies', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->string('sponsor_id');
            $table->string('location_id')->nullable();
            $table->string('position', 50);
            $table->string('left_leg_id')->nullable();
            $table->string('right_leg_id')->nullable();
            $table->bigInteger('activation_amount')->default(0);
            $table->integer('total_left_paid')->default(0);
            $table->integer('total_right_paid')->default(0);
            $table->string('package_id')->nullable();
            $table->timestamp('last_topup_time', $precision = 0)->nullable();
            $table->timestamp('activation_time', $precision = 0)->nullable();
            $table->string('activated_by')->nullable();
            $table->integer('left_leg_count')->default(0);
            $table->integer('right_leg_count')->default(0);
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
        Schema::dropIfExists('hirarchies');
    }
}
