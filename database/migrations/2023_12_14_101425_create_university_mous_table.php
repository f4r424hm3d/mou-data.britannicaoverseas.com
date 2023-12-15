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
    Schema::create('university_mous', function (Blueprint $table) {
      $table->id();
      $table->text('title')->nullable();
      $table->text('file_name');
      $table->text('file_path');
      $table->unsignedBigInteger('university_id');
      $table->foreign('university_id')->references('id')->on('universities');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('university_mous');
  }
};
