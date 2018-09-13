<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Textbook extends Model {
	use Cachable;
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'textbooks';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'isbn';
	protected $keyType = 'string';
	public $incrementing = false;

	/**
	 * Attributes that should be mass-assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'isbn',
		'book-title',
		'author',
		'book-des',
		'edition',
		'image-url',
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
	protected $casts = [];

	protected $appends = [
		'average_price', 'image-url',
	];
	/**
	 * Get the bookRating for this model.
	 */
	public function bookRating() {
		return $this->hasOne('App\Models\BookRating', 'isbn', 'isbn');
	}

	/**
	 * Get the posts for this model.
	 */
	public function posts() {
		return $this->hasMany('App\Models\Post', 'isbn', 'isbn');
	}

	/**
	 * Get the on campus for this model.
	 */
	public function businessPosts() {
		return $this->hasMany('App\Models\StandPost', 'isbn', 'isbn');
	}

	/**
	 * Get the tagsTextbooks for this model.
	 */
	public function textbookTags() {
		return $this->hasMany('App\Models\TextbookTag', 'isbn', 'isbn');
	}

	/**
	 * Get the tagsTextbooks for this model.
	 */
	public function views() {
		return $this->hasMany('App\Models\TextbookView', 'isbn-viewed', 'isbn');
	}

	/**
	 * the users meta
	 *
	 * @return mixed
	 */
	public function tags() {
		return $this->hasManyThrough('App\Models\Tag', 'App\Models\TextbookTag', 'isbn', 'tag-id', 'isbn', 'tag-id');
	}

	/**
	 * the users meta
	 *
	 * @return mixed
	 */
	public function stands() {
		return $this->hasManyThrough('App\Models\BusinessStand', 'App\Models\StandPost', 'isbn', 'id', 'isbn', 'stand_id');
	}

	/**
	 * the users meta
	 *
	 * @return mixed
	 */
	public function purchases() {
		return $this->hasManyThrough('App\Models\Order', 'App\Models\Post', 'isbn', 'post-id', 'isbn', 'post-id');
	}

	/**
	 * the users meta
	 *
	 * @return mixed
	 */
	public function universities() {
		return $this->hasManyThrough('App\Models\WebometricUniversity', 'App\Models\Post', 'isbn', 'uni-id', 'isbn', 'uni-id')->distinct();
	}

	/**
	 * Get the textbookClasses for this model.
	 */
	public function textbookClasses() {
		return $this->hasMany('App\Models\TextbookClass', 'isbn', 'isbn');
	}

	/**
	 * Get the textbookMetas for this model.
	 */
	public function textbookMetas() {
		return $this->hasMany('App\Models\TextbookMetum', 'isbn', 'isbn');
	}

	/**
	 * Get the userBookPics for this model.
	 */
	public function userBookPics() {
		return $this->hasMany('App\Models\UserBookPic', 'isbn', 'isbn');
	}

	public function scopeWithPriceAverage($query) {
		//Alternate way to get price, but does not have currency symbol

		$price = $query->selectRaw('ROUND(AVG(COALESCE(posts.price, 0)) - (COALESCE(posts.price, 0) * 0.05)) AS average')->join('posts', 'textbooks.isbn', 'posts.isbn')->groupBy('textbooks.isbn');
	}

	public function getAveragePriceAttribute() {
		$price = $this->posts()->avg('price');
		return "€" . round(($price - ($price * 0.05)), 0);
	}

	public function getMinPriceAttribute() {
		return "€" . $this->posts()->min('price');
	}

	public function getMaxPriceAttribute() {
		return "€" . $this->posts()->max('price');
	}

	/**
	 * Get the books cover image, enforce https, and switch to CDN link if available.
	 */
	public function getImageUrlAttribute() {
		$this->attributes['image-url'] = preg_replace("/^http:/i", "https:", $this->attributes['image-url']);
		return str_replace("https://justbookrbucket.s3.eu-west-1.amazonaws.com/images/Uploads", "https://content.justbookr.com", $this->attributes['image-url']);
	}

}
