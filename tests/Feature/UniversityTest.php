<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WebometricUniversity;
use Tests\TestCase;

class UniversityTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListUniversities() {
		$response = $this->json('GET', '/api/v1/universities');
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListUniversity() {
		$university = WebometricUniversity::inRandomOrder()->active()->first();
		$response = $this->json('GET', '/api/v1/universities/' . $university->{'uni-id'});
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateUniversityAsGuest() {
		$university = WebometricUniversity::inRandomOrder()->active()->first();
		$response = $this->json('PATCH', '/api/v1/universities/' . $university->{'uni-id'});
		$response->assertStatus(401);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateUniversityAsGuest() {
		$response = $this->json('POST', '/api/v1/universities');
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testDeleteUniversityAsGuest() {
		$university = WebometricUniversity::inRandomOrder()->inactive()->first();
		$response = $this->json('DELETE', '/api/v1/universities/' . $university->{'uni-id'});
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testDeleteUniversityAsAuthenticatedUser() {
		$university = WebometricUniversity::inRandomOrder()->inactive()->first();
		$user = User::find(config('app.admin_id'));
		$response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/universities/' . $university->{'uni-id'});
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateUniversityAsAuthenticatedUser() {
		$user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/universities', ['university-description' => 'TEST - ASSERTION UNIVERSITY', 'price' => '100', 'isbn' => '1000000000001', 'uni-id' => '16763']);
		$response->assertStatus(403);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateUniversityAsAuthenticatedUserWithPermission() {
		$user = User::find(config('app.admin_id'));
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/universities', ['university-description' => 'TEST - ASSERTION UNIVERSITY', 'price' => '100', 'isbn' => '1000000000001', 'uni-id' => '16763']);
		$response->assertStatus(201);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testDeleteUniversityAsAuthenticatedUserWithoutPermission() {
		$university = WebometricUniversity::inRandomOrder()->inactive()->first();
		$user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
		$response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/universities/' . $university->{'uni-id'});
		$response->assertStatus(403);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateUniversityAsAuthenticatedUserWithoutPermission() {
		$user = User::inRandomOrder()->where('user-id', '!=', config('app.admin_id'))->first();
		$university = WebometricUniversity::inRandomOrder()->inactive()->first();
		$response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/universities/' . $university->{'uni-id'});
		$response->assertStatus(403);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateUniversityAsAuthenticatedUserWithPermission() {
		$university = WebometricUniversity::inactive()->first();
		$user = User::find(config('app.admin_id'));
		$response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/universities/' . $university->{'uni-id'}, $university->toArray());
		$response->assertStatus(200);
	}

}