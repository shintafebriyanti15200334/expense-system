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
        //
        Schema::create('audit_trails', function (Blueprint $table) {
    $table->id();

    $table->foreignId('user_id')->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->string('module');
    $table->string('action');

    $table->foreignId('submission_id')
          ->nullable()
          ->constrained()
          ->nullOnDelete();

    $table->text('description')->nullable();

    $table->ipAddress('ip_address')->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('audit_trail');
    }
};
