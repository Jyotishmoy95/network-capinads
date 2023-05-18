<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->string('fname', 255);
            $table->string('lname', 255);
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('mobile', 25);
            $table->string('photo', 255)->default('blank-user.webp');
            $table->string('password', 255);
            $table->string('plain_pwd', 255);
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('members');
    }
}
