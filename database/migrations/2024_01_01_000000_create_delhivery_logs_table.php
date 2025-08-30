<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('delhivery_logs', function (Blueprint $table) {
      $table->id();
      $table->string('waybill')->nullable();
      $table->string('reference_no')->nullable();
      $table->string('endpoint');
      $table->string('method');
      $table->json('request_data')->nullable();
      $table->json('response_data')->nullable();
      $table->integer('status_code')->nullable();
      $table->text('error_message')->nullable();
      $table->timestamps();

      $table->index('waybill');
      $table->index('reference_no');
      $table->index('created_at');
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('delhivery_logs');
  }
};
