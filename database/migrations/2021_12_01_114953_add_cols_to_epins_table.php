<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToEpinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epins', function (Blueprint $table) {
            $table->string('activated_by')->nullable();
            $table->enum('account_type', ['user', 'admin'])->nullable();
            $table->string('week_day')->nullable();
            $table->integer('month_day')->nullable();
            $table->integer('total')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('epins', function (Blueprint $table) {
            $table->dropColumn(['activated_by', 'account_type', 'week_day', 'month_day', 'total']);
        });
    }
}
