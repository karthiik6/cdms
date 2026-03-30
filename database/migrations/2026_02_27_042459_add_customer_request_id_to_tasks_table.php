<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->unsignedBigInteger('customer_request_id')->nullable();

            $table->foreign('customer_request_id')
                ->references('id')->on('customer_requests')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (\Illuminate\Database\Schema\Blueprint $table) {
            $table->dropForeign(['customer_request_id']);
            $table->dropColumn('customer_request_id');
        });
    }
};
