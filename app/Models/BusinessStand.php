<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessStand extends Model {

	use SoftDeletes, Cachable;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'business_stands';

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
		'business_id',
		'uni_id',
		'stand_text',
		'location',
		'is_active',
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
	 * Get the business for this model.
	 */
	public function business() {
		return $this->belongsTo('App\Models\Business', 'business_id');
	}

	/**
	 * Get the uni for this model.
	 */
	public function university() {
		return $this->belongsTo('App\Models\University', 'uni_id');
	}

	/**
	 * Get the books for this model.
	 */
	public function posts() {
		return $this->hasMany('App\Models\StandPost', 'stand_id');
	}

	/**
	 * Get the deleted_at date in UNIX format
	 *
	 * @param  string  $value
	 * @return array
	 */
	public function getDeletedAtAttribute($value) {
		return date('U', strtotime($value));
	}

	public function scopeActive($query) {
		return $query->where('is_active', '1');
	}

}
