<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\PermissionsTableSeeder;
use Tests\TestCase;


class UsersTest extends TestCase
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

    public function testIndex()
    {
        $response = $this->actingAs($this->user)->get(route('users.index'));
        $response
            ->assertStatus(200)
            ->assertViewHas(['users', 'search'])
            ->assertViewIs('users.index');

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testCreate()
    {
        $response = $this->actingAs($this->user, 'web')
            ->get(route('users.create'));

        $response
            ->assertViewIs('users.create')
            ->assertStatus(200);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testEditView()
    {
        $users = User::create([
            'name'              => 'carmen',
            'email'             => 'carmen@hotmail.com',
            'active'            => 1,
            'email_verified_at' => now(),
            'password'          => '123456',
        ]);

        $response = $this->actingAs($this->user, 'web')
            ->get(route('users.edit', $users->id));

        $response
            ->assertStatus(200)
            ->assertViewIs('users.edit');

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testUpdate()
    {
        $user = User::create([
            'name'              => 'carmen',
            'email'             => 'carmen@hotmail.com',
            'active'            => 1,
            'email_verified_at' => now(),
            'password'          => '123456',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('users.update', $user->id), [
                'name'      => 'carmelo',
                'email'     => 'carmen@hotmail.com',
                'active'    => 1,
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id'   => $user->id,
            'name' => 'carmelo'
        ]);
    }

    public function testStore(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('users.store'), [
                'name'      => 'new',
                'email'     => 'sdcarmen@hotmail.com',
                'active'    => 1,
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'name'    => 'new',
            'email'   => 'sdcarmen@hotmail.com',
            'active'  => 1,
        ]);

        $this->assertAuthenticatedAs($this->user, $guard = null);
    }

    public function testUpdateActive()
    {
        $user = User::create([
            'name'              => 'carmen',
            'email'             => 'carmen@hotmail.com',
            'active'            => 1,
            'email_verified_at' => now(),
            'password'          => '123456',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('users.active', $user->id), [
                'active' => 0
            ]);

        $response
            ->assertStatus(302)
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseHas('users', [
            'id'     => $user->id,
            'name'   => 'carmen',
            'active' => 0
        ]);
    }

    public function testStoreErrors(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('users.store'), []);

        $response->assertSessionHasErrors([
            'name',
            'email',
        ]);
    }

    public function testUpdateErrors(): void
    {
        $response = $this->actingAs($this->user)
            ->put(route('users.update', $this->user->id), []);

        $response->assertSessionHasErrors([
            'name',
        ]);
    }

}
