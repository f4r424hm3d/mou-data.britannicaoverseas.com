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
    Schema::create('universities', function (Blueprint $table) {
      $table->id();
      $table->string('name', 200);
      $table->string('slug', 200);
      $table->string('institute_type', 200)->nullable();
      $table->string('address', 200)->nullable();
      $table->string('city', 100)->nullable();
      $table->string('state', 100)->nullable();
      $table->string('country', 100)->nullable();
      $table->string('phone_number', 20)->nullable();
      $table->string('phone_number2', 20)->nullable();
      $table->string('phone_number3', 20)->nullable();
      $table->string('email', 100)->nullable();
      $table->string('email2', 100)->nullable();
      $table->string('email3', 100)->nullable();
      $table->string('whatsapp', 100)->nullable();
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
    Schema::dropIfExists('universities');
  }
};
