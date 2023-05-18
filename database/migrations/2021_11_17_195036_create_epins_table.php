<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epins', function (Blueprint $table) {
            $table->id();
            $table->string('epin_code', 255);
            $table->boolean('status')->default(0);
            $table->string('issued_to', 255);
            $table->bigInteger('amount');
            $table->string('used_by', 255)->nullable();
            $table->string('generated_by', 255);
            $table->timestamp('used_at', $precision = 0)->nullable();
            $table->integer('package_id');
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
        Schema::dropIfExists('epins');
    }
}
