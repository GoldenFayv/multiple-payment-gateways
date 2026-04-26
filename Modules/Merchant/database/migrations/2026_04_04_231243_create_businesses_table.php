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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('merchant_id')->constrained("merchants")->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();

            $table->unique(['name', 'merchant_id']);
        });

        Schema::table('merchants', function (Blueprint $table) {
            $table->foreignId('active_business_id')->nullable()->constrained('businesses')->nullOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
