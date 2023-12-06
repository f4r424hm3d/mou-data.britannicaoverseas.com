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
    Schema::table('users', function (Blueprint $table) {
      $table->string('username', 150)->unique()->after('email');
      $table->bigInteger('mobile')->nullable()->after('email');
      $table->string('role', 50)->after('id');
      $table->bigInteger('login_count')->nullable();
      $table->string('os', 100)->nullable()->after('login_count');
      $table->string('browser', 100)->nullable()->after('login_count');
      $table->string('browser_version', 100)->nullable()->after('login_count');
      $table->string('ip_address', 100)->nullable()->after('login_count');
      $table->string('mac', 100)->nullable()->after('login_count');
      $table->boolean('status')->default('0')->after('login_count');
      $table->text('profile_picture')->nullable()->after('status');
      $table->dateTime('last_login')->nullable();
      $table->integer('otp')->nullable()->after('last_login');
      $table->string('otp_expire_at', 40)->nullable()->after('last_login');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      //
    });
  }
};
