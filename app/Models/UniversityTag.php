<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class UniversityTag extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'university_tags';

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
        'uni_id',
        'tag_id',
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
}
