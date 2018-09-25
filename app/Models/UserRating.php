<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class UserRating extends Model
{
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
    protected $table = 'user_ratings';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'rate_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user-id',
        'rating',
        'timestamp',
        'rated_by',
        'comment',
        'connect-id',
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
    protected $casts = [];

    /**
     * Get the rate for this model.
     */
    public function rate()
    {
        return $this->belongsTo('App\Models\Rate', 'rate_id');
    }

    /**
     * Get the user for this model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user-id', 'user-id');
    }

    /**
     * Get the ratedBy for this model.
     */
    public function ratedBy()
    {
        return $this->belongsTo('App\Models\User', 'rated_by');
    }

    /**
     * Set the timestamp.
     *
     * @param string $value
     *
     * @return void
     */
    public function setTimestampAttribute($value)
    {
        $this->attributes['timestamp'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get timestamp in array format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getTimestampAttribute($value)
    {
        return date('U', strtotime($value));
    }

    public function scopePositive($query)
    {
        return $query->where('rating', '>', '3');
    }

    public function scopeNegative($query)
    {
        return $query->where('rating', '<=', '3');
    }
}
