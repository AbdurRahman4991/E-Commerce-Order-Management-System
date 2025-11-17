<?php
namespace Tests\Feature;
use Tests\TestCase;

class ProductTest{
    public function test_vendor_can_create_product()
{
    $vendor = User::factory()->vendor()->create();

    $payload = [
        'vendor_id' => $vendor->id,
        'name' => 'Test Shirt',
        'variants' => [
            [
                'sku' => 'TS-001',
                'price' => 199.99,
                'stock' => 50,
                'attribute' => 'size=L'
            ]
        ]
    ];

    $this->actingAs($vendor, 'api')
        ->postJson('/api/v1/products', $payload)
        ->assertStatus(201)
        ->assertJsonStructure(['data' => ['id', 'variants']]);
}

}


