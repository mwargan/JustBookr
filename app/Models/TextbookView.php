<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class TextbookView extends Model
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
    protected $table = 'textbook_user_view';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'tview-id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user-id',
        'view_IP',
        'isbn-viewed',
        'uni-viewed',
        'date-viewed',
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
    protected $casts = ['date-viewed' => 'date:U'];

    /**
     * Set the dateviewed.
     *
     * @param string $value
     *
     * @return void
     */
    public function setDateviewedAttribute($value)
    {
        $this->attributes['date-viewed'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }
}
