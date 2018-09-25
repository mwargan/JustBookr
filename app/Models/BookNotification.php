<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookNotification extends Model {

	use SoftDeletes, Cachable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'book_notifications';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Attributes that should be mass-assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'user_id',
		'uni_id',
		'isbn',
	];

	/**
	 * The attributes that should be mutated to dates.
	 *
	 * @var array
	 */
	protected $dates = [
		'deleted_at',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [];

	/**
	 * Get the user for this model.
	 */
	public function user() {
		return $this->belongsTo('App\Models\User', 'user_id');
	}

	/**
	 * Get the uni for this model.
	 */
	public function uni() {
		return $this->belongsTo('App\Models\University', 'uni_id');
	}

	/**
	 * Get the uni for this model.
	 */
	public function book() {
		return $this->belongsTo('App\Models\Textbook', 'isbn');
	}

	/**
	 * Get deleted_at in array format
	 *
	 * @param  string  $value
	 * @return array
	 */
	public function getDeletedAtAttribute($value) {
		return date('U', strtotime($value));
	}

}
