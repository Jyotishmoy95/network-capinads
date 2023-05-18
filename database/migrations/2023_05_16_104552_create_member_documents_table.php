<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_documents', function (Blueprint $table) {
            $table->id();
            $table->string('member_id', 255);
            $table->enum('document_type', ['aadhar', 'pan', 'passport', 'driving_license', 'other']);
            $table->string('document_number', 255);
            $table->string('document_photo', 255);
            $table->boolean('status')->default(0)->comment('0-pending, 1-approved, 2-rejected');
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
        Schema::dropIfExists('member_documents');
    }
}
