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
    Schema::table('universities', function (Blueprint $table) {
      $table->string('logo_name', 100)->nullable()->after('whatsapp');
      $table->text('logo_path')->nullable()->after('logo_name');
      $table->string('banner_name', 100)->nullable()->after('logo_path');
      $table->text('banner_path')->nullable()->after('banner_name');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('universities', function (Blueprint $table) {
      //
    });
  }
};
