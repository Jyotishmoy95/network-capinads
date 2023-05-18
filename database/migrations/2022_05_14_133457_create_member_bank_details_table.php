<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->string('bank_name', 255);
            $table->string('account_name', 255);
            $table->string('account_number', 255);
            $table->string('ifsc_code', 255);
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
        Schema::dropIfExists('member_bank_details');
    }
}
