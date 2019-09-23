<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\CacheTags;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    use Cachable;

    protected function makeCacheTags(): array
    {
        $eagerLoad = $this->eagerLoad ?? [];
        $model = $this->model instanceof Model ? $this->model : $this; // edited
        $query = $this->query instanceof Builder ? $this->query : app(Builder::class);
        $tags = (new CacheTags($eagerLoad, $model, $query->getQuery()))->make();

        return $tags;
    }

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
    protected $table = 'searches';

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
        'query',
        'user',
        'uni',
        'results_count',
        'timestamp',
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
     * Get the user for this model.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user-id', 'user');
    }

    /**
     * Get the user for this model.
     */
    public function university()
    {
        return $this->belongsTo('App\Models\University', 'uni-id', 'uni');
    }

    /**
     * Set the timestamp.
     *
     * @param string $value
     *
     * @return void
     */
    public function setTimestampAttribute($value)
    {
        $this->attributes['timestamp'] = ! empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get timestamp in array format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getTimestampAttribute($value)
    {
        return date('U', strtotime($value));
    }
}
