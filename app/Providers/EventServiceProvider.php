<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider {
	/**
	 * The event listener mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\Event' => [
			'App\Listeners\EventListener',
		],
		'App\Events\OrderCreated' => [
			'App\Listeners\SendOrderNotification',
			'App\Listeners\SendBill',
		],
		'App\Events\OrderAccepted' => [
			'App\Listeners\SendOrderConfirmation',
		],
		'App\Events\OrderCanceled' => [
			'App\Listeners\SendOrderCancelation',
		],
		'App\Events\OrderUpdated' => [
			//'App\Listeners\NotifySeller',
			'App\Listeners\NotifyBuyer', //INCLUDES BOTH NOTIFICATIONS
		],
		'App\Events\RatingAdded' => [
			'App\Listeners\RunRating',
		],
		'App\Events\PostAdded' => [
			'App\Listeners\AddUserPoints',
			'App\Listeners\LogPost',
			'App\Listeners\NotifyWaitlist',
		],
		'App\Events\UniversityAdded' => [
			//'App\Listeners\AddTags',
		],
		'App\Events\BookAdded' => [
			'App\Listeners\AddTags',
		],
		'App\Events\TagAdded' => [
			'App\Listeners\AddTagsToBooks',
			'App\Listeners\AddTagsToUniversities',
		],
		'Illuminate\Auth\Events\Login' => [
			'App\Listeners\LogSuccessfulLogin',
		],
		'Illuminate\Auth\Events\Failed' => [
			'App\Listeners\LogFailedLogin',
		],

		'Illuminate\Auth\Events\Logout' => [
			'App\Listeners\LogSuccessfulLogout',
		],
		'Illuminate\Auth\Events\Registered' => [
			'App\Listeners\LogRegisteredUser',
		],
	];

	/**
	 * Register any events for your application.
	 *
	 * @return void
	 */
	public function boot() {
		parent::boot();

		//
	}
}
