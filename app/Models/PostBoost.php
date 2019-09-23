<?php

namespace App\Models;

use Carbon\Carbon;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostBoost extends Model
{
    use SoftDeletes, Cachable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'post_boosts';

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
        'post_id',
        'expires_at',
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
    protected $casts = ['expires_at' => 'date:U'];

    /**
     * Get the postT for this model.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post_id');
    }

    /**
     * Set the expires_at.
     *
     * @param string $value
     *
     * @return void
     */
    public function setExpiresAtAttribute($value)
    {
        $this->attributes['expires_at'] = ! empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get expires_at in array format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getExpiresAtAttribute($value)
    {
        return date('U', strtotime($value));
    }

    /**
     * Get deleted_at in array format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getDeletedAtAttribute($value)
    {
        return date('U', strtotime($value));
    }

    public function scopeActive($query)
    {
        return $query->where('expires_at', '>=', Carbon::now());
    }
}
