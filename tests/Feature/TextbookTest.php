<?php

namespace Tests\Feature;

use App\Models\Textbook;
use App\Models\User;
use Tests\TestCase;

class TextbookTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListTextbooks() {
		$response = $this->json('GET', '/api/v1/books');
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListTextbook() {
		$book = Textbook::inRandomOrder()->first();
		$response = $this->json('GET', '/api/v1/books/' . $book->isbn);
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateTextbookAsGuest() {
		$book = Textbook::inRandomOrder()->first();
		$response = $this->json('PATCH', '/api/v1/books/' . $book->isbn);
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateTextbookAsGuest() {
		$response = $this->json('POST', '/api/v1/books');
		$response->assertStatus(401);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateTextbookAsAuthenticatedUserWithoutPermission() {
		$user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/books');
		$response->assertStatus(403);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateTextbookAsAuthenticatedUserWithoutPermission() {
		$user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
		$response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/books/9780071314671');
		$response->assertStatus(403);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateTextbookAsAuthenticatedUserWithPermission() {
		$user = User::find(config('app.admin_id'));
		$book = array();
		$book['isbn'] = rand(1000000000000, 9999999999999);
		$book['book-title'] = "Test Book";
		$book['author'] = "Test Author";
		$book['edition'] = "X";
		$book['image-url'] = "https://randomlink.tono";
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/books', $book);
		$response->assertStatus(201);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateTextbookAsAuthenticatedUserWithPermission() {
		$book = Textbook::inRandomOrder()->first();
		$user = User::find(config('app.admin_id'));
		$response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/books/' . $book->isbn, $book->toArray());
		$response->assertStatus(200);
	}
}
