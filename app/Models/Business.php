<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use SoftDeletes, Cachable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'businesses';

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
        'name',
        'description',
        'website',
        'logo',
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
     * Get the stands for this model.
     */
    public function stands()
    {
        return $this->hasMany('App\Models\BusinessStand', 'business_id');
    }

    /**
     * Get the users for this model.
     */
    public function users()
    {
        return $this->hasManyThrough('App\Models\User', 'App\Models\UsersBusiness', 'business_id', 'user-id', 'id', 'user_id');
    }

    /**
     * Get the deleted_at date in UNIX format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getDeletedAtAttribute($value)
    {
        return date('U', strtotime($value));
    }
}
