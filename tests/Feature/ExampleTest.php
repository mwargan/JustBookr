<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicTest() {
		$response = $this->get('/');

		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicLoginViewTest() {
		$response = $this->get('/login');

		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicSignupViewTest() {
		$response = $this->get('/sign-up');

		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBasicPasswordResetViewTest() {
		$response = $this->get('/password/reset');

		$response->assertStatus(200);
	}
}
