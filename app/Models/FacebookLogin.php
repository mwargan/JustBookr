<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookLogin extends Model {

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
	protected $table = 'fb_login';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'fb-user-id';
	protected $keyType = 'string';
	public $incrementing = false;

	/**
	 * Attributes that should be mass-assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'fb-user-id',
		'user-id',
		'sync-profile-pic',
		'fb_name',
		'fb_surname',
		'fb_email',
		'fb_gender',
		'fb_profilepic',
		'fb_link',
		'fb_location',
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

	/**
	 * Get the user for this model.
	 */
	public function user() {
		return $this->belongsTo('App\Models\User', 'user-id', 'user-id');
	}

}
