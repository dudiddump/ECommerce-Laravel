<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_product()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Testing',
            'price' => 10000,
            'status' => 'active'
        ]);

        $response->assertStatus(201);
    }

    public function test_user_cannot_create_product()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/products', [
            'name' => 'Test Product',
            'description' => 'Testing',
            'price' => 10000,
            'status' => 'available'
        ]);

        $response->assertStatus(403);
    }
}