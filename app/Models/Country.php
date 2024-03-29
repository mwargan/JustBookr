<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
    protected $table = 'countries';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'iso2';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso2',
        'iso3',
        'name',
        'currency',
        'currency_iso',
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
    protected $casts = [
        'iso2' => 'string',
    ];

    /**
     * Get the universities for this model.
     */
    public function universities()
    {
        return $this->hasMany('App\Models\University', 'country_id', 'id');
    }
}
