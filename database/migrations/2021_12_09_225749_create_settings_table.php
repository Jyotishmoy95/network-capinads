<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('welcome_letter')->nullable();
            $table->boolean('login_blocked')->default(false);
            $table->boolean('registration_blocked')->default(false);
            $table->boolean('activation_blocked')->default(false);
            $table->boolean('withdrawal_blocked')->default(false);
            $table->boolean('welcome_letter_show')->default(false);
            $table->boolean('ad_blocked')->default(false);
            $table->decimal('income_per_ad', 10, 2)->default(0);
            $table->decimal('minumum_withdrawal', 10, 2)->nullable();
            $table->decimal('maximum_withdrawal', 10, 2)->nullable();
            $table->decimal('admin_charges', 10, 2)->default(0);
            $table->enum('income_credit_type', ['one', 'all'])->nullable();
            $table->decimal('self_income', 10, 2)->default(0);
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
        Schema::dropIfExists('settings');
    }
}
