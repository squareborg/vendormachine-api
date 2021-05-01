<?php

namespace Tests\Unit;

use App\Events\ProductCreated;
use App\Models\Products\Product;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Vendor;
use App\Transformers\ProductTransformer;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function it_stores_a_product()
    {
        Event::fake('App\Events\ProductCreated');

        $vendor = factory(Vendor::class)->create();
        $product = factory(Product::class)->make([
            'vendor_id' => $vendor->id,
        ]);
        $product['price'] = random_int(100,10000);
        $response = $this->actingAs($vendor->user, 'api')->post(route('products.store', $vendor), $product->toArray());
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'vendor_id' => $vendor->id
        ]);
        Event::assertDispatched(ProductCreated::class, function ($e) use ($response) {
        return $e->product->id === $response->json()['id'];
        });
    }

    /** @test */
    public function it_does_not_stores_a_product_if_you_cannot_manage_products_on_vendor()
    {
        Event::fake('App\Events\ProductCreated');

        $vendor = factory(Vendor::class)->create();
        $product = factory(Product::class)->make();
        $product['price'] = random_int(100,10000);
        $response = $this->actingAs($vendor->user, 'api')->post(route('products.store', $vendor), $product->toArray());
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseMissing('products', [
            'name' => $product->name,
            'vendor_id' => $vendor->id
        ]);
        Event::assertNotDispatched(ProductCreated::class);
    }

    /** @test */
    public function it_lists_a_users_products()
    {
        $paginateLength = 15;
        $vendor = factory(Vendor::class)->create();
        $products = factory(Product::class,30)->create([
            'vendor_id' => $vendor->id
        ]);
        $response = $this->actingAs($vendor->user, 'api')->get(route('products.index'));
        $response->assertOk();
        $data = $response->json()['data'];
        foreach($data as $product) {
            $this->assertEquals($product['vendor_id'], $vendor->id);
        }
        $this->assertCount($paginateLength, $data);
    }

    /** @test */
    public function it_does_not_list_other_vendors_products_to_non_admins()
    {
        $otherVendor = factory(Vendor::class)->create();
        $products = factory(Product::class,30)->create([
            'vendor_id' => $otherVendor->id
        ]);
        $vendor = factory(Vendor::class)->create();

        $response = $this->actingAs($vendor->user, 'api')->get(route('products.index'));
        $data = $response->json()['data'];
        foreach($data as $product) {
            $this->assertEquals($product['vendor_id'], $vendor->id);
        }
        $this->assertCount(0, $data);
    }

    /** @test */
    public function it_lists_all_vendors_products_to_admins()
    {
        $admin = $this->createAdminApiUser();
        factory(Product::class,15)->create();

        $response = $this->actingAs($admin, 'api')->get(route('products.index'));
        $data = $response->json()['data'];
        $this->assertCount(15, $data);
    }

    /** @test */
    public function it_updates_a_product()
    {
        $product = factory(Product::class)->create(['name' => 'Old Name']);
        $product['name'] = 'The New Name';
        $response = $this->actingAs($product->vendor->user, 'api')
            ->putJson(route('products.update', $product), $product->toArray());
        dd($response);
        $response->assertOk();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'name' => 'The New Name']);
    }

    /** @test */
    public function it_does_not_update_a_product_you_do_not_own()
    {
        $user = $this->createApiUser();
        $product = factory(Product::class)->create(['name' => 'Old Name']);
        $product['name'] = 'The New Name';
        $response = $this->actingAs($user, 'api')
            ->put(route('products.update', $product), $product->toArray())
            ->assertForbidden();
        $this->assertDatabaseMissing('products', ['id' => $product->id, 'name' => 'The New Name']);
    }

    /** @test */
    public function it_shows_a_single_product()
    {
        $product = factory(Product::class)->create();
        $transformed = fractal()->item($product, new ProductTransformer)->toArray();
        $this->actingAs($product->vendor->user, 'api')
            ->get(route('products.show', $product))
            ->assertOk()->assertJsonFragment($transformed);
    }

    /** @test */
    public function it_does_not_show_a_single_product_to_non_owner()
    {
        $product = factory(Product::class)->create();
        $this->actingAs($this->createApiUser(), 'api')
            ->get(route('products.show', $product))
            ->assertForbidden();
    }

    public function it_stores_a_product_variant()
    {
        Event::fake('App\Events\ProductCreated');

        $vendor = factory(Vendor::class)->create();
        $product = factory(Product::class)->make([
            'vendor_id' => $vendor->id,
        ]);
        $product['price'] = random_int(100,10000);
        $response = $this->actingAs($vendor->user, 'api')->post(route('products.store', $vendor), $product->toArray());
        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'vendor_id' => $vendor->id
        ]);
        Event::assertDispatched(ProductCreated::class, function ($e) use ($response) {
            return $e->product->id === $response->json()['id'];
        });
    }
}


