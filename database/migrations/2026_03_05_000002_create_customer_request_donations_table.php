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
        Schema::create('customer_request_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_request_id')->constrained('customer_requests')->onDelete('cascade');
            $table->foreignId('donor_id')->constrained('users')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->string('status')->default('Pledged');
            $table->timestamps();

            $table->unique(['customer_request_id', 'donor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_request_donations');
    }
};
