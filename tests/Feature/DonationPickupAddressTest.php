<?php

namespace Tests\Feature;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DonationPickupAddressTest extends TestCase
{
    use RefreshDatabase;

    public function test_donor_must_provide_pickup_address_when_submitting_donation(): void
    {
        Storage::fake('public');

        $donor = User::factory()->create(['role' => 'donor']);

        $response = $this->actingAs($donor)->post('/donations', [
            'items' => [
                [
                    'category' => 'Shirt',
                    'size' => 'M',
                    'condition' => 'Good',
                    'quantity' => 2,
                ],
            ],
            'photo' => UploadedFile::fake()->create('donation.jpg', 200, 'image/jpeg'),
        ]);

        $response->assertSessionHasErrors('pickup_address');
    }

    public function test_donor_pickup_address_is_saved_with_donation(): void
    {
        Storage::fake('public');

        $donor = User::factory()->create(['role' => 'donor']);

        $response = $this->actingAs($donor)->post('/donations', [
            'donation_date' => '2026-03-29',
            'pickup_address' => '221B Baker Street, Near City Center',
            'items' => [
                [
                    'category' => 'Jacket',
                    'size' => 'L',
                    'condition' => 'Good',
                    'quantity' => 1,
                ],
            ],
            'photo' => UploadedFile::fake()->create('donation.jpg', 200, 'image/jpeg'),
        ]);

        $response->assertRedirect('/donations');

        $this->assertDatabaseHas('donations', [
            'donor_id' => $donor->id,
            'pickup_address' => '221B Baker Street, Near City Center',
            'status' => 'Pending',
        ]);

        $this->assertSame('221B Baker Street, Near City Center', Donation::firstOrFail()->pickup_address);
    }
}
