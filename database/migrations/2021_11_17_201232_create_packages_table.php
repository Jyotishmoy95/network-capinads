<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name', 255);
            $table->bigInteger('amount');
            $table->decimal('self_ad_income',  10, 2)->default(0);
            $table->boolean('status')->default(1);
            $table->enum('roi_type', ['flat', 'percent'])->nullable();
            $table->decimal('roi', 10, 2)->nullable();
            $table->integer('roi_days')->nullable();
            $table->enum('binary_type', ['flat', 'percent'])->nullable();
            $table->decimal('binary', 10, 2)->nullable();
            $table->enum('level_type', ['flat', 'percent'])->nullable();
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
        Schema::dropIfExists('packages');
    }
}
