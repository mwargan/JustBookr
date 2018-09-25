<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListUsers()
    {
        $response = $this->json('GET', '/api/v1/users');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListUser()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
        $response = $this->json('GET', '/api/v1/users/'.$user->{'user-id'});
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUserAsAuthenticatedUser()
    {
        $user = User::find(config('app.admin_id'));
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/users', [
            'name'    => 'Test',
            'surname' => 'Account',
            'email'   => 'httptestaccount@outlook.com',
        ]);
        $response->assertStatus(201);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateUserAsAuthenticatedUserWithoutPermission()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/users');
        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetSelfDataAsAuthenticatedUser()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/v1/me');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetSelfNotificationsAsAuthenticatedUser()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/v1/me/notifications');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetUsersPostViewsAsAuthenticatedUser()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
        $response = $this->actingAs($user, 'api')->json('GET', '/api/v1/me/post-views');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateUserAsAuthenticatedUser()
    {
        $recent_user = User::orderBy('user-id', 'desc')->first();
        $response = $this->actingAs($recent_user, 'api')->json('PATCH', '/api/v1/users/'.$recent_user->{'user-id'}, ['name' => 'Test', 'surname' => 'Account', 'email' => 'httptestaccount@outlook.com']);
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateUserAsAuthenticatedUserWithoutPermission()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->where('user-id', '!=', 3)->first();
        $response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/users/3');
        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteUserAsAuthenticatedUserWithoutPermission()
    {
        $user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->where('user-id', '!=', 3)->first();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/users/3');
        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeleteUserAsAuthenticatedUser()
    {
        $delete_user = User::orderBy('user-id', 'desc')->first();
        $response = $this->actingAs($delete_user, 'api')->json('DELETE', '/api/v1/users/'.$delete_user->{'user-id'});
        $response->assertStatus(200);
    }
}
