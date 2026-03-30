<?php

namespace Tests\Feature;

use App\Models\ClothingRequest;
use App\Models\CustomerRequest;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminVolunteerAssignmentValidationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_donation_assignment_rejects_non_volunteer_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $donor = User::factory()->create(['role' => 'donor']);
        $donation = Donation::create([
            'donor_id' => $donor->id,
            'pickup_address' => '123 Pickup Street',
            'status' => 'Pending',
        ]);

        $this->actingAs($admin)
            ->post("/admin/donations/{$donation->id}/assign", ['volunteer_id' => $donor->id])
            ->assertSessionHasErrors('volunteer_id');
    }

    public function test_admin_request_assignment_rejects_non_volunteer_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $donor = User::factory()->create(['role' => 'donor']);
        $beneficiary = \App\Models\Beneficiary::create([
            'name' => 'Test Beneficiary',
            'email' => 'beneficiary@example.com',
            'phone' => '1234567890',
            'address' => 'Test Address',
        ]);
        $request = ClothingRequest::create([
            'beneficiary_id' => $beneficiary->id,
            'status' => 'Pending',
        ]);

        $this->actingAs($admin)
            ->post("/admin/requests/{$request->id}/assign", ['volunteer_id' => $donor->id])
            ->assertSessionHasErrors('volunteer_id');
    }

    public function test_admin_customer_request_assignment_rejects_non_volunteer_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);
        $donor = User::factory()->create(['role' => 'donor']);
        $request = CustomerRequest::create([
            'customer_id' => $customer->id,
            'status' => 'Approved',
            'delivery_location' => 'Test Address',
            'donor_donation_allowed' => false,
        ]);

        $this->actingAs($admin)
            ->post("/admin/customer-requests/{$request->id}/assign", ['volunteer_id' => $donor->id])
            ->assertSessionHasErrors('volunteer_id');
    }

    public function test_non_admin_cannot_access_admin_requests_page(): void
    {
        $donor = User::factory()->create(['role' => 'donor']);

        $this->actingAs($donor)
            ->get('/admin/requests')
            ->assertForbidden();
    }
}
