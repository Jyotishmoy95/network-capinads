<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_levels', function (Blueprint $table) {
            $table->id();
            $table->integer('package_id');
            $table->integer('level');
            $table->decimal('amount', 10, 2)->default(0);
            $table->integer('direct_referrals');
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
        Schema::dropIfExists('package_levels');
    }
}
