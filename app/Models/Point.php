<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Point extends Model
{

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
    protected $table = 'user_points';

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
        'points',
        'action',
        'user-id',
        'timestamp',
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
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user-id', 'user-id');
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
}
