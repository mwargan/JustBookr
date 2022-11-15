<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


    const CREATED_AT = 'timestamp';
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
    protected $table = 'connected_users';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'connect-id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user-id-sell',
        'user-id-buy',
        'post-id',
        'comment',
        'timestamp',
        'location-meet',
        'location-date',
        'location-time',
        'replied',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'timestamp',
        'location-date',
        'replied',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];
    protected $appends = [
        'location-date',
    ];

    /**
     * Get the post for this model.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post-id', 'post-id');
    }

    /**
     * Get the buyer for this model.
     */
    public function buyer()
    {
        return $this->belongsTo('App\Models\User', 'user-id-buy', 'user-id');
    }

    /**
     * DEPRECIATED -> USER post->user !!! Get the seller for this model.
     */
    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'user-id-sell', 'user-id');
    }

    /**
     * Get the rating for this model.
     */
    public function rating()
    {
        return $this->hasOne('App\Models\UserRating', 'connect-id', 'connect-id');
    }

    /**
     * Get the rating for this model.
     */
    public function ratings()
    {
        return $this->hasMany('App\Models\UserRating', 'connect-id', 'connect-id');
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
     * Set the locationdate.
     *
     * @param string $value
     *
     * @return void
     */
    public function setLocationDateAttribute($value)
    {
        $this->attributes['location-date'] = !empty($value) ? date($this->getDateFormat(), strtotime('@' . $value)) : null;
    }

    /**
     * Set the replied.
     *
     * @param string $value
     *
     * @return void
     */
    public function setRepliedAttribute($value)
    {
        $this->attributes['replied'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
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

    /**
     * Get locationdate in array format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getLocationDateAttribute()
    {
        return $this->attributes['location-date'] ? date('U', strtotime($this->attributes['location-date'])) : null;
    }

    /**
     * Get the date of reply in UNIX format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getRepliedAttribute($value)
    {
        return $value ? date('U', strtotime($value)) : null;
    }

    public function scopeReplied($query)
    {
        return $query->whereNotNull('replied');
    }

    public function scopeUnreplied($query)
    {
        return $query->whereNull('replied');
    }
}
