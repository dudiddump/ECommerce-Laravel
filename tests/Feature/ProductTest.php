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
        $admin = User::factory()->create(['role' => 'admin']);

        $data = [
            'name' => 'Test Product',
            'description' => 'Testing',
            'price' => 10000,
            'status' => 'active'
        ];

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/products', $data);

        $response->assertStatus(201);
        
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 10000
        ]);
    }

    public function test_user_cannot_create_product()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/products', [
            'name' => 'Illegal Product',
            'description' => 'Testing',
            'price' => 10000,
            'status' => 'active'
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_product()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $product = Product::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
                         ->deleteJson("/api/products/{$product->id}");

        $response->assertStatus(200);
        
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_anyone_can_view_products()
    {
        Product::factory()->count(3)->create(['status' => 'active']);

        $response = $this->getJson('/api/products');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }
}