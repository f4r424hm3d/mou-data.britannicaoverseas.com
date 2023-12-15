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
    Schema::create('university_followups', function (Blueprint $table) {
      $table->id();
      $table->text('comment');
      $table->timestamp('next_follow_up')->nullable();
      $table->unsignedBigInteger('university_id');
      $table->foreign('university_id')->references('id')->on('universities');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('university_followups');
  }
};
