<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 20)->nullable()->after('email');
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->string('contact_phone', 20)->nullable()->after('pickup_address');
            $table->boolean('show_volunteer_details_to_donor')->default(false)->after('status');
        });

        Schema::table('customer_requests', function (Blueprint $table) {
            $table->string('contact_phone', 20)->nullable()->after('delivery_location');
            $table->boolean('show_volunteer_details_to_customer')->default(false)->after('donor_donation_allowed');
        });
    }

    public function down(): void
    {
        Schema::table('customer_requests', function (Blueprint $table) {
            $table->dropColumn(['contact_phone', 'show_volunteer_details_to_customer']);
        });

        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['contact_phone', 'show_volunteer_details_to_donor']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};
