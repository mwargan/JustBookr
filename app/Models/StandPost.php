<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class StandPost extends Model
{
    use Cachable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stand_posts';

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
        'stand_id',
        'isbn',
        'description',
        'price',
        'is_active',
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
     * Get the stand for this model.
     */
    public function stand()
    {
        return $this->belongsTo('App\Models\BusinessStand', 'stand_id');
    }

    public function textbook()
    {
        return $this->hasOne('App\Models\Textbook', 'isbn', 'isbn');
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_active', '1')->whereHas('stand', function ($q) {
            $q->active();
        });
    }

    public function scopeActive($query)
    {
        return $query->whereHas('stand', function ($q) {
            $q->active();
        });
    }

    public function getCurrencyAttribute()
    {
        return $this->stand->university->country->currency;
    }

    public function getPriceAttribute($value)
    {
        return "{$this->currency}{$value}";
    }
}
