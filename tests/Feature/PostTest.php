<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListPosts()
    {
        $response = $this->json('GET', '/api/v1/posts');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testListPost()
    {
        $post = Post::inRandomOrder()->available()->first();
        $response = $this->json('GET', '/api/v1/posts/'.$post->{'post-id'});
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdatePostAsGuest()
    {
        $post = Post::inRandomOrder()->available()->first();
        $response = $this->json('PATCH', '/api/v1/posts/'.$post->{'post-id'});
        $response->assertStatus(401);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreatePostAsGuest()
    {
        $response = $this->json('POST', '/api/v1/posts');
        $response->assertStatus(401);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeletePostAsGuest()
    {
        $post = Post::inRandomOrder()->available()->first();
        $response = $this->json('DELETE', '/api/v1/posts/'.$post->{'post-id'});
        $response->assertStatus(401);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeletePostAsAuthenticatedUser()
    {
        $post = Post::inRandomOrder()->available()->first();
        $user = $post->user;
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/posts/'.$post->{'post-id'});
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreatePostAsAuthenticatedUser()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/posts', ['post-description' => 'TEST - ASSERTION POST', 'price' => '100', 'isbn' => '1000000000001', 'uni-id' => '16763']);
        $response->assertStatus(201);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDeletePostAsAuthenticatedUserWithoutPermission()
    {
        $post = Post::inRandomOrder()->available()->first();
        $user = User::where('user-id', '!=', $post->{'user-id'})->first();
        $response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/posts/'.$post->{'post-id'});
        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdatePostAsAuthenticatedUserWithoutPermission()
    {
        $user = User::latest('user-registered')->first();
        $post = Post::inRandomOrder()->available()->where('user-id', '!=', $user->{'user-id'})->first();
        $response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/posts/'.$post->{'post-id'});
        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdatePostAsAuthenticatedUserWithPermission()
    {
        $post = Post::latest('date')->available()->first();
        $user = $post->user;
        $response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/posts/'.$post->{'post-id'}, ['post-description' => 'TEST - ASSERTION POST', 'price' => '100', 'uni-id' => '16763']);
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMarkSoldPostAsAuthenticatedUserWithPermission()
    {
        $post = Post::latest('date')->available()->first();
        $user = $post->user;
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/posts/'.$post->{'post-id'}.'/mark-sold');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMarkSoldPostAsAuthenticatedUserWithoutPermission()
    {
        $post = Post::latest('date')->available()->first();
        $user = User::where('user-id', '!=', $post->{'user-id'})->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/posts/'.$post->{'post-id'}.'/mark-sold');
        $response->assertStatus(403);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMarkUnsoldPostAsAuthenticatedUserWithPermission()
    {
        $post = Post::latest('date')->unavailable()->first();
        $user = $post->user;
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/posts/'.$post->{'post-id'}.'/mark-available');
        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMarkUnsoldPostAsAuthenticatedUserWithoutPermission()
    {
        $user = User::latest('user-registered')->first();
        $post = Post::inRandomOrder()->unavailable()->where('user-id', '!=', $user->{'user-id'})->first();
        $response = $this->actingAs($user, 'api')->json('POST', '/api/v1/posts/'.$post->{'post-id'}.'/mark-available');
        $response->assertStatus(403);
    }
}
