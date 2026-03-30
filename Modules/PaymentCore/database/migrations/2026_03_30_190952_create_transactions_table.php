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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->string('gateway');
            $table->string('internal_reference')->unique();
            $table->string('gateway_reference')->nullable();
            $table->integer('amount');
            $table->string('currency');
            $table->string('customer_email');
            $table->string('status');
            $table->string('callback_url')->nullable();
            $table->json('metadata')->nullable();
            $table->json('gateway_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
