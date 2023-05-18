<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activations', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->string('activated_by', 255);
            $table->decimal('amount', 10, 2);
            $table->integer('topup_count');
            $table->decimal('total_roi', 10, 2);
            $table->tinyInteger('wallet_type');
            $table->timestamp('next_roi', $precision = 0)->nullable();
            $table->decimal('roi_percent', 10, 2);
            $table->string('account_type', 255);
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
        Schema::dropIfExists('activations');
    }
}
