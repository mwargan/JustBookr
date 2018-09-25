<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class University extends Model
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
    protected $table = 'webometric_universities';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'uni-id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uni-name',
        'en-name',
        'abr',
        'country_id',
        'city',
        'address',
        'description',
        'uni-tel',
        'uni-pic',
        'uni-logo',
        'uni-lat',
        'uni-lon',
        'url',
    ];
    protected $hidden = [
        'uni-lat', 'uni-long',
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
        'uni-logo',
    ];

    /**
     * Get the country for this model.
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id', 'id');
    }

    /**
     * Get the posts for this model.
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'uni-id', 'uni-id');
    }

    /**
     * Get the uniClasses for this model.
     */
    public function uniClasses()
    {
        return $this->hasMany('App\Models\UniClass', 'uni-id', 'uni-id');
    }

    /**
     * Get the users for this model.
     */
    public function users()
    {
        return $this->hasMany('App\Models\User', 'uni-id', 'uni-id');
    }

    /**
     * Get the tagsTextbooks for this model.
     */
    public function bookViews()
    {
        return $this->hasMany('App\Models\TextbookView', 'uni-viewed', 'uni-id');
    }

    /**
     * the university books meta.
     *
     * @return mixed
     */
    public function books()
    {
        return $this->hasManyThrough('App\Models\Textbook', 'App\Models\Post', 'uni-id', 'isbn', 'uni-id', 'isbn')->distinct();
    }

    public function getPostsCountAttribute()
    {
        return $this->posts()->count();
    }

    public function scopeActive($query)
    {
        return $query->whereHas('users', function ($q) {
            $q->active();
        });
    }

    public function scopeInactive($query)
    {
        return $query->whereHas('users', function ($q) {
            $q->inactive();
        });
    }

    public function getUniLogoAttribute()
    {
        return preg_replace('/^http:/i', 'https:', $this->attributes['uni-logo']);
    }
}
