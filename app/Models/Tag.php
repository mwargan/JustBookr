<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
    protected $table = 'tags';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'tag-id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        't-data',
        't-pic',
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
     * Get the tagsTextbooks for this model.
     */
    public function textbookTag()
    {
        return $this->hasMany('App\Models\TextbookTag', 'tag-id', 'tag-id');
    }

    /**
     * Get the textbooks for this model.
     */
    public function textbooks()
    {
        return $this->hasManyThrough('App\Models\Textbook', 'App\Models\TextbookTag', 'tag-id', 'isbn', 'tag-id', 'isbn');
    }

    /**
     * Get the universities for this model.
     */
    public function universities()
    {
        return $this->hasManyThrough('App\Models\University', 'App\Models\UniversityTag', 'tag_id', 'uni-id', 'tag-id', 'uni_id');
    }
}
