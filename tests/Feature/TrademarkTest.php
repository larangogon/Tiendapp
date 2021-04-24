<?php

namespace Tests\Feature;

use App\Models\Trademark;
use App\Models\User;
use Database\Seeders\PermissionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrademarkTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PermissionsTableSeeder::class);

        $this->user = \App\Models\User::factory(User::class)
            ->create([
                'active' => 1
            ]);

        $this->user->assignRole('Administrator');
    }

    public function testIndex(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('trademarks.index'));

        $response
            ->assertStatus(200)
            ->assertViewHas('trademarks')
            ->assertViewIs('trademarks.index');
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('trademarks.store'), [
                'name' => 'Adidies',
                'code' => '2345678'
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('trademarks.index'));

        $this->assertDatabaseHas('trademarks', [
            'name' => 'Adidies',
            'code' => '2345678'
        ]);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user, 'web')
            ->get(route('trademarks.create'));

        $response
            ->assertViewIs('trademarks.create')
            ->assertStatus(200);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testDestroy()
    {
        $this->withoutExceptionHandling();
        $trademark = Trademark::create([
            'name'   => 'name',
            'code'   => '2345678',

        ]);

        $response = $this->actingAs($this->user, 'web')
            ->delete(route('trademarks.destroy', $trademark->id), [
                'id'  => $trademark->id
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('trademarks.index'));

        $this->assertDatabaseMissing('products', [
            'id'  => $trademark->id,
        ]);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }
}
