<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->string('transfered_by', 255);
            $table->decimal('amount', 10, 2);
            $table->decimal('deduction', 10, 2)->default(0);
            $table->decimal('net', 10, 2);
            $table->tinyInteger('sender_wallet_type')->default(0)->comment('0: Admin');
            $table->tinyInteger('receiver_wallet_type');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('fund_transfers');
    }
}
