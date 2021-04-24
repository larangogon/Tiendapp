<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Size;
use App\Models\Trademark;
use App\Models\User;
use Database\Seeders\PermissionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private $user;
    private $size;
    private $trademark;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionsTableSeeder::class);

        $this->user = \App\Models\User::factory(User::class)
            ->create([
                'active' => 1
            ]);

        $this->user->assignRole('Administrator');

        $this->size = \App\Models\Size::factory(Size::class)->create();
        $this->trademark = \App\Models\Trademark::factory(Trademark::class)->create();
    }

    public function testIndex()
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user, 'web')
            ->get(route('products.index'));

        $response
            ->assertStatus(200)
            ->assertViewHas(['products', 'search'])
            ->assertViewIs('products.index');

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $products = Product::create([
            'name'        => 'name',
            'description' => 'description',
            'price'       => 100000,
            'stock'       => 5,

        ]);

        $response = $this->actingAs($this->user, 'web')
            ->delete(route('products.destroy', $products->id), [
                'id'  => $products->id
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Eliminado Satisfactoriamente !');

        $this->assertDatabaseMissing('products', [
            'id'  => $products->id,
        ]);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testUpdate()
    {
        $this->withoutExceptionHandling();
        $product = Product::create([
            'name'        => 'name',
            'description' => 'description',
            'price'       => 5666,
            'stock'       => 5,
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('products.update', $product->id), [
                'name'      => 'nameup',
                'stock'     => $product->stock,
                'size'      => [$this->size->id]
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'Producto Editado Satisfactoriamente');

        $this->assertDatabaseHas('products', [
            'id'    => $product->id,
            'name'  => 'nameup',
            'stock' => $product->stock,
        ]);

        $this->assertDatabaseHas('product_size', [
            'product_id' => $product->id,
            'size_id'    => [$this->size->id],
        ]);
    }

    public function testStore(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->actingAs($this->user)
            ->post(route('products.store'), [
                'name'        => 'new',
                'stock'       => 56,
                'price'       => 23456,
                'description' => 'jdhfbgyebhsabfreahbfgy',
                'size'        => [$this->size->id],
                'trademark'    => [$this->trademark->id],
                'img'         => '0af47a0f0bb89e7ce4d88f121faea42b.jpg'
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('success', 'producto Creado Satisfactoriamente');

        $this->assertDatabaseHas('products', [
            'name'  => 'new'
        ]);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testStoreErrors(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('products.store'), []);

        $response
            ->assertSessionHasErrors(['stock',
                'name', 'price',
                'img', 'size', 'trademark'
            ])
            ->assertStatus(302);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user, 'web')
            ->get(route('products.create'));

        $response
            ->assertViewIs('products.create')
            ->assertStatus(200);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testEditView()
    {
        $product = Product::create([
            'name'        => 'new',
            'stock'       => 56,
            'price'       => 23456,
            'description' => 'jdhfbgyebhsabfreahbfgy',
            'size'        => [$this->size->id],
            'trademark'   => [$this->trademark->id],
            'img'         => '0af47a0f0bb89e7ce4d88f121faea42b.jpg'
        ]);

        $response = $this->actingAs($this->user, 'web')
            ->get(route('products.edit', $product->id));

        $response
            ->assertStatus(200)
            ->assertViewIs('products.edit');

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testShow()
    {
        $product = Product::create([
            'name'        => 'new',
            'stock'       => 56,
            'price'       => 23456,
            'description' => 'jdhfbgyebhsabfreahbfgy',
            'size'        => [$this->size->id],
            'trademark'    => [$this->trademark->id],
            'img'         => '0af47a0f0bb89e7ce4d88f121faea42b.jpg',
            'active'      => 1
        ]);

        $response = $this->actingAs($this->user, 'web')
            ->get(route('products.show', $product->id));

        $response
            ->assertStatus(200)
            ->assertViewHas([
                'product',
            ])
            ->assertViewIs('products.show');

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testUpdateActive()
    {
        $product = Product::create([
            'name'        => 'name',
            'description' => 'description',
            'price'       => 5666,
            'stock'       => 5,
            'active'      => 0
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('products.active', $product->id), [
                'active' => 1
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('products.index'))
            ->assertSessionHas('message', 'Estatus del producto Editado Satisfactoriamente !');

        $this->assertDatabaseHas('products', [
            'id'     => $product->id,
            'name'   => 'name',
            'active' => 1
        ]);
    }
}
