<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model {

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
	protected $table = 'post_comments';

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
		'postid',
		'userid',
		'comment',
		'comment_timestamp',
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
	 * Get the post for this model.
	 */
	public function post() {
		return $this->belongsTo('App\Models\Post', 'post-id', 'post-id');
	}

	/**
	 * Get the user for this model.
	 */
	public function user() {
		return $this->belongsTo('App\Models\User', 'user-id', 'user-id');
	}

	/**
	 * Set the comment_timestamp.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setCommentTimestampAttribute($value) {
		$this->attributes['comment_timestamp'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
	}

	/**
	 * Get comment_timestamp in array format
	 *
	 * @param  string  $value
	 * @return array
	 */
	public function getCommentTimestampAttribute($value) {
		return date('U', strtotime($value));
	}

}
