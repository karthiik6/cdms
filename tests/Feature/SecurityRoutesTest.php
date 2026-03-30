<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityRoutesTest extends TestCase
{
    public function test_guest_is_redirected_when_accessing_admin_inventory(): void
    {
        $this->get('/admin/inventory')
            ->assertRedirect('/login');
    }
}
