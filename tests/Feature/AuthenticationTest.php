<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'email' => 'teste@example.com',
            'password' => Hash::make('password'),
            'status' => true,
        ]);

        $response = $this->post(
            route('login.store'),
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );

        $response->assertRedirect(route('events.index'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'email' => 'inativo@example.com',
            'password' => Hash::make('password'),
            'status' => false,
        ]);

        $response = $this->post(
            route('login.store'),
            [
                'email' => $user->email,
                'password' => 'password',
            ]
        );

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_non_admin_cannot_access_admin_area(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get(
            route('admin.events.index')
        );

        $response->assertForbidden();
    }

    public function test_admin_can_access_admin_area(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(
            route('admin.events.index')
        );

        $response->assertOk();
    }
}