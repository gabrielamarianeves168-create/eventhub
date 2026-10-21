<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_cancel_another_users_registration(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();
        $event = Event::factory()->create();

        $registration = Registration::factory()->create([
            'user_id' => $userB->id,
            'event_id' => $event->id,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($userA)->delete(
            route(
                'registrations.destroy',
                $registration
            )
        );

        $response->assertForbidden();

        $this->assertDatabaseHas(
            'registrations',
            [
                'id' => $registration->id,
                'status' => 'confirmed',
            ]
        );
    }
}