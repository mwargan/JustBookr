<?php

namespace App\Providers;

use App\Models\BookNotification;
use App\Models\Business;
use App\Models\BusinessStand;
use App\Models\Country;
use App\Models\Order;
use App\Models\Post;
use App\Models\PostBoost;
use App\Models\Search;
use App\Models\StandPost;
use App\Models\Tag;
use App\Models\Textbook;
use App\Models\TextbookView;
use App\Models\User;
use App\Models\UserRating;
use App\Models\WebometricUniversity;
use App\Policies\BookNotificationPolicy;
use App\Policies\BusinessPolicy;
use App\Policies\BusinessStandPolicy;
use App\Policies\CountryPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PostBoostPolicy;
use App\Policies\PostPolicy;
use App\Policies\SearchPolicy;
use App\Policies\StandPostPolicy;
use App\Policies\TagPolicy;
use App\Policies\TextbookPolicy;
use App\Policies\TextbookViewPolicy;
use App\Policies\UserPolicy;
use App\Policies\UserRatingPolicy;
use App\Policies\WebometricUniversityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		//'App\Models\Post' => 'App\Policies\ModelPolicy',
		Post::class => PostPolicy::class,
		Order::class => OrderPolicy::class,
		StandPost::class => StandPostPolicy::class,
		BusinessStand::class => BusinessStandPolicy::class,
		Textbook::class => TextbookPolicy::class,
		UserRating::class => UserRatingPolicy::class,
		WebometricUniversity::class => WebometricUniversityPolicy::class,
		User::class => UserPolicy::class,
		Country::class => CountryPolicy::class,
		Tag::class => TagPolicy::class,
		Business::class => BusinessPolicy::class,
		PostBoost::class => PostBoostPolicy::class,
		BookNotification::class => BookNotificationPolicy::class,
		Search::class => SearchPolicy::class,
		Tag::class => TagPolicy::class,
		TextbookView::class => TextbookViewPolicy::class,
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerPolicies();

		Passport::routes();

		Passport::enableImplicitGrant();

	}
}
