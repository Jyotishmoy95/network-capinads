<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->string('username', 255);
            $table->decimal('amount', 10, 2);
            $table->decimal('deduction', 10, 2)->default(0);
            $table->decimal('net', 10, 2);
            $table->enum('type', ['credit', 'debit']);
            $table->string('remark', 255)->nullable();
            $table->boolean('wallet_type');
            $table->tinyInteger('status')->default(0)->comment('0: Pending, 1: Paid, 2: Rejected');
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
        Schema::dropIfExists('wallets');
    }
}
