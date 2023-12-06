<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('concern_people', function (Blueprint $table) {
      $table->id();
      $table->string('name', 100);
      $table->string('mobile', 20)->nullable();
      $table->string('whatsapp', 20)->nullable();
      $table->string('personal_email', 200)->nullable();
      $table->string('official_email', 100)->nullable();
      $table->string('designation', 100)->nullable();
      $table->unsignedBigInteger('university_id');
      $table->foreign('university_id')->references('id')->on('universities');
      $table->unsignedBigInteger('created_by');
      $table->foreign('created_by')->references('id')->on('users');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('concern_people');
  }
};
