<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class OrderTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListOrders() {
		$user = User::latest('user-registered')->first();
		$response = $this->actingAs($user, 'api')->json('GET', '/api/v1/orders');
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListOrdersAsGuest() {
		$response = $this->json('GET', '/api/v1/orders');
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListOrder() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', $order->{'user-id-buy'})->orWhere('user-id', $order->{'user-id-sell'})->first();
		$response = $this->actingAs($user, 'api')->json('GET', '/api/v1/orders/' . $order->{'connect-id'});
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testListOrderAsGuest() {
		$response = $this->json('GET', '/api/v1/orders/1');
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateOrderAsGuest() {
		$response = $this->json('PATCH', '/api/v1/orders/1');
		$response->assertStatus(401);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateOrderAsGuest() {
		$response = $this->json('POST', '/api/v1/orders');
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testDeleteOrderAsGuest() {
		$response = $this->json('DELETE', '/api/v1/orders/1');
		$response->assertStatus(401);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testDeleteOrderAsAuthenticatedUser() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', $order->{'user-id-buy'})->orWhere('user-id', $order->{'user-id-sell'})->first();
		$response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/orders/' . $order->{'connect-id'});
		$response->assertStatus(200);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCreateOrderAsAuthenticatedUser() {
		$post = Post::latest('date')->available()->where('uni-id', 16763)->where('user-id', '!=', config('app.admin_id'))->first();
		$user = User::latest('user-registered')->where('uni-id', $post->{'uni-id'})->where('user-id', '!=', $post->{'user-id'})->first();
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/orders', ['post-id' => $post->{'post-id'}, 'location-meet' => 'Here', 'location-date' => Carbon::now()->timestamp]);
		$response->assertStatus(201);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testDeleteOrderAsAuthenticatedUserWithoutPermission() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', '!=', $order->{'user-id-buy'})->where('user-id', '!=', $order->{'user-id-sell'})->first();
		$response = $this->actingAs($user, 'api')->json('DELETE', '/api/v1/orders/' . $order->{'connect-id'});
		$response->assertStatus(403);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateOrderAsAuthenticatedUserWithoutPermission() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', '!=', $order->{'user-id-buy'})->where('user-id', '!=', $order->{'user-id-sell'})->first();
		$response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/orders/' . $order->{'connect-id'});
		$response->assertStatus(403);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testUpdateOrderAsAuthenticatedUserWithPermission() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', $order->{'user-id-buy'})->orWhere('user-id', $order->{'user-id-sell'})->first();
		$response = $this->actingAs($user, 'api')->json('PATCH', '/api/v1/orders/' . $order->{'connect-id'}, ['location-meet' => 'Here', 'location-date' => Carbon::now()->timestamp]);
		$response->assertStatus(200);
	}

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testAcceptAsAuthenticatedUserWithoutPermission() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', '!=', $order->post->{'user-id'})->first();
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/orders/' . $order->{'connect-id'} . '/accept');
		$response->assertStatus(403);
	}
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testAcceptAsAuthenticatedUserWithPermission() {
		$order = Order::latest('timestamp')->first();
		$user = User::where('user-id', $order->post->{'user-id'})->first();
		$response = $this->actingAs($user, 'api')->json('POST', '/api/v1/orders/' . $order->{'connect-id'} . '/accept');
		$response->assertStatus(200);
	}

}