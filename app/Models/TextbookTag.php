<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class TextbookTag extends Model
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
    protected $table = 'tags_textbooks';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'tt-id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tag-id',
        'isbn',
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
     * Get the tag for this model.
     */
    public function tag()
    {
        return $this->belongsTo('App\Models/\Tag', 'tag-id', 'tag-id');
    }

    /**
     * Get the textbook for this model.
     */
    public function textbook()
    {
        return $this->belongsTo('App\Models/\Textbook', 'isbn', 'isbn');
    }
}
