<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersBusiness extends Model
{
    use SoftDeletes, Cachable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_businesses';

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
        'user_id',
        'is_admin',
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
    public function businesses()
    {
        return $this->belongsToMany('App\Models\Business', 'business_id');
    }

    /**
     * Get the user for this model.
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_id');
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
}
