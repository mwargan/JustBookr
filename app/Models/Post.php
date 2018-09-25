<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	use Cachable;

	const CREATED_AT = 'date';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The relations to eager load on every query.
	 *
	 * @var array
	 */
	protected $with = ['boosts', 'university.country:countries.id,countries.currency,countries.name'];

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'post-id';

	/**
	 * Attributes that should be mass-assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user-id',
		'date',
		'post-description',
		'isbn',
		'quality',
		'uni-id',
		'sku',
		'price',
		'status',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = ['date' => 'date:U'];

	/**
	 * The attributes that are hidden.
	 *
	 * @var array
	 */
	protected $hidden = [
		'sku', 'quality',
	];
	/**
	 * Get the user for this model.
	 */
	public function user() {
		return $this->belongsTo('App\Models\User', 'user-id', 'user-id');
	}

	/**
	 * Get the textbook for this model.
	 */
	public function textbook() {
		return $this->belongsTo('App\Models\Textbook', 'isbn', 'isbn');
	}

	/**
	 * Get the University for this model.
	 */
	public function university() {
		return $this->belongsTo('App\Models\University', 'uni-id', 'uni-id');
	}

	/**
	 * Get the connectedUser for this model.
	 */
	public function order() {
		return $this->hasOne('App\Models\Order', 'post-id', 'post-id');
	}

	/**
	 * Get the connectedUsers for this model.
	 */
	public function connectedUsers() {
		return $this->hasMany('App\Models\ConnectedUser', 'user-id-sell', 'user-id');
	}

	/**
	 * Get the connectedUsers for this model.
	 */
	public function boosts() {
		return $this->hasMany('App\Models\PostBoost', 'post_id', 'post-id')->active();
	}

	/**
	 * Get the postComments for this model.
	 */
	public function postComments() {
		return $this->hasMany('App\Models\PostComment', 'post-id', 'post-id');
	}

	/**
	 * Get the reportedPosts for this model.
	 */
	public function reportedPosts() {
		return $this->hasMany('App\Models\ReportedPost', 'post-id', 'post-id');
	}

	/**
	 * Get the userBookPics for this model.
	 */
	public function userBookPics() {
		return $this->hasMany('App\Models\UserBookPic', 'post-id', 'post-id');
	}

	/**
	 * Get the businesses for this model.
	 *
	 * @return mixed
	 */
	public function views() {
		//return dd($this);
		return $this->hasManyThrough('App\Models\TextbookView', 'App\Models\Textbook', 'isbn', 'isbn-viewed', 'isbn', 'isbn');
	}

	/**
	 * Set the date.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setDateAttribute($value) {
		$this->attributes['date'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
	}

	public function scopeAvailable($query) {
		return $query->where('status', 1);
	}

	public function scopeWithViews($query) {
		return $query->withCount([
			// from the related table views
			'views' => function ($q) {
				// limit results to 'in the past month'
				$q->whereRaw('`date-viewed` >= DATE_SUB(NOW(),INTERVAL 1 MONTH)')

					->whereRaw('`date-viewed` >= posts.date')

					->where(function ($query) {
						// limit to on-place, or not
						$query->whereRaw('`uni-viewed` = posts.`uni-id`')->orWhereNull('uni-viewed');
					})
					->where(function ($query) {
						// limit to on-place, or not
						$query->whereRaw('`user-id` != posts.`user-id`')->orWhereNull('user-id');
					});
			},
		]);
	}

	public function scopeActive($query) {
		return $query->whereHas('user', function ($q) {
			$q->active();
		});
	}

	public function getPriceAttribute($value) {
		return "{$this->university->country->currency}{$value}";
	}

	// DEPRECIATING, USING SCOPE
	public function getViewsAttribute() {
		return $this->views()->whereRaw('`date-viewed` >= DATE_SUB(NOW(),INTERVAL 1 MONTH)')

			->where('date-viewed', '>=', $this->date)

			->where(function ($query) {
				// limit to on-place, or not
				$query->where('uni-viewed', $this->{'uni-id'})->orWhereNull('uni-viewed');
			})
			->where(function ($query) {
				// limit to on-place, or not
				$query->where('user-id', '!=', $this->{'user-id'})->orWhereNull('user-id');
			})
			->distinct()->count();
	}

}
