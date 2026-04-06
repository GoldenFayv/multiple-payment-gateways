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
        Schema::create('merchant_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade')->cascadeOnUpdate();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('webhook_url')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_apps');
    }
};
