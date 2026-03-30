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
        Schema::table('tasks', function (Blueprint $table) {
            // make donation_id nullable
            $table->unsignedBigInteger('donation_id')->nullable()->change();

            // add request id
            $table->foreignId('clothing_request_id')->nullable()
                ->constrained('clothing_requests')
                ->nullOnDelete();

            // type already exists; ensure it can be 'distribution' too (string is fine)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['clothing_request_id']);
            $table->dropColumn('clothing_request_id');
            $table->unsignedBigInteger('donation_id')->nullable(false)->change();
        });
    }
};
