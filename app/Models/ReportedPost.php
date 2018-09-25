<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportedPost extends Model
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
    protected $table = 'reported_posts';

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
        'reported_by',
        'post-id',
        'reason',
        'report_time',
        'resolved',
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
        return $this->belongsTo('App\Models\User', 'reported_by', 'user-id');
    }

    /**
     * Get the post for this model.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'post-id', 'post-id');
    }

    /**
     * Set the report_time.
     *
     * @param string $value
     *
     * @return void
     */
    public function setReportTimeAttribute($value)
    {
        $this->attributes['report_time'] = !empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Get report_time in array format.
     *
     * @param string $value
     *
     * @return array
     */
    public function getReportTimeAttribute($value)
    {
        return date('U', strtotime($value));
    }
}
