<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Billable;

    const CREATED_AT = 'user-registered';

    protected $rememberTokenName = 'sess-id';

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
    protected $table = 'users';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'user-id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'about-me',
        'username',
        'password',
        'email',
        'uni-id',
        'country',
        'city',
        'address',
        'user-tel',
        'user-registered',
        'userlevel',
        'profilepic',
        'last_login',
        'last_ip_access',
        'sess-id',
    ];
    protected $hidden = [
        'password', 'email', 'city', 'address', 'user-tel', 'last_ip_access', 'sess-id', 'userlevel', 'country', 'username', 'about-me', 'seen', 'card_brand', 'card_last_four', 'stripe_id', 'trial_ends_at', 'surname',
    ];

    /**
     * Route notifications for the Slack channel.
     *
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return config('services.slack.webhook');
    }

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
        'last_login'      => 'date:U',
        'seen'            => 'date:U',
        'user-registered' => 'date:U',
    ];

    protected $appends = [
        'positive_ratings', 'profilepic', 'points',
    ];

    /**
     * Get the University for this model.
     */
    public function university()
    {
        return $this->belongsTo('App\Models\University', 'uni-id', 'uni-id');
    }

    /**
     * Get the activityfeeds for this model.
     */
    public function bookNotifications()
    {
        return $this->hasMany('App\Models\BookNotification', 'user_id', 'user-id');
    }

    /**
     * Get the connectedUsers for this model.
     */
    public function purchases()
    {
        return $this->hasMany('App\Models\Order', 'user-id-buy', 'user-id');
    }

    /**
     * Get the connectedUsers for this model.
     */
    // public function sales() {
    //     return $this->hasMany('App\Models\Order', 'user-id-sell', 'user-id');
    // }

    // hasManyThrough($related, $through, $firstKey = null, $secondKey = null, $localKey = null, $secondLocalKey = null)
    public function sales()
    {
        return $this->hasManyThrough('App\Models\Order', 'App\Models\Post', 'user-id', 'post-id', 'user-id', 'post-id');
    }

    // public function businesses() {
    //     return $this->hasManyThrough('App\Models\Business', 'App\Models\UsersBusiness', 'user_id', 'id', 'user-id', 'business_id')->where('is_active', 1);
    // }

    /**
     * Get the fbLogin for this model.
     */
    public function fbLogin()
    {
        return $this->hasOne('App\Models\FbLogin', 'user-id', 'user-id');
    }

    /**
     * Get the postComments for this model.
     */
    public function postComments()
    {
        return $this->hasMany('App\Models\PostComment', 'user-id', 'user-id');
    }

    /**
     * Get the posts for this model.
     */
    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'user-id', 'user-id');
    }

    /**
     * Get the reportedPosts for this model.
     */
    public function reportedPosts()
    {
        return $this->hasMany('App\Models\ReportedPost', 'reported_by', 'user-id');
    }

    /**
     * Get the token for this model.
     */
    public function token()
    {
        return $this->hasOne('App\Models\Token', 'user-id', 'user-id');
    }

    /**
     * Get the userBookPics for this model.
     */
    public function userBookPics()
    {
        return $this->hasMany('App\Models\UserBookPic', 'user-id', 'user-id');
    }

    /**
     * Get the userPoints for this model.
     */
    public function points()
    {
        return $this->hasMany('App\Models\Point', 'user-id', 'user-id');
    }

    /**
     * Get the userRatings for this model.
     */
    public function userRatings()
    {
        return $this->hasMany('App\Models\UserRating', 'user-id', 'user-id');
    }

    /**
     * Get the userRatings for this model.
     */
    public function positiveRatings()
    {
        return $this->hasMany('App\Models\UserRating', 'user-id', 'user-id')->positive();
    }

    /**
     * Get the userRatings for this model.
     */
    public function negativeRatings()
    {
        return $this->hasMany('App\Models\UserRating', 'user-id', 'user-id')->negative();
    }

    /**
     * Get the businessRoles for this model.
     */
    public function businessRoles()
    {
        return $this->hasMany('App\Models\UsersBusiness', 'user_id', 'user-id');
    }

    /**
     * Get the businesses for this model.
     *
     * @return mixed
     */
    public function businesses()
    {
        return $this->hasManyThrough('App\Models\Business', 'App\Models\UsersBusiness', 'user_id', 'id', 'user-id', 'business_id')->where('is_active', 1);
    }

    /**
     * Get the businesses for this model.
     *
     * @return mixed
     */
    public function postedBooks()
    {
        return $this->hasManyThrough('App\Models\Textbook', 'App\Models\Post', 'user-id', 'isbn', 'user-id', 'isbn');
    }

    /**
     * Set the userregistered.
     *
     * @param string $value
     *
     * @return void
     */
    public function setUserregisteredAttribute($value)
    {
        $this->attributes['userregistered'] = ! empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Set the seen.
     *
     * @param string $value
     *
     * @return void
     */
    public function setSeenAttribute($value)
    {
        $this->attributes['seen'] = ! empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    /**
     * Set the last_login.
     *
     * @param string $value
     *
     * @return void
     */
    public function setLastLoginAttribute($value)
    {
        $this->attributes['last_login'] = ! empty($value) ? date($this->getDateFormat(), strtotime($value)) : null;
    }

    public function scopeActive($query)
    {
        return $query->whereDate('last_login', '>=', date('Y-m-d', strtotime('-6 months')));
    }

    public function scopeInactive($query)
    {
        return $query->whereDate('last_login', '<', date('Y-m-d', strtotime('-6 months')));
    }

    public function getPointsAttribute()
    {
        return round($this->points()->sum('points'));
    }

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->surname;
    }

    public function getPositiveRatingsAttribute()
    {
        return $this->positiveRatings()->count();
    }

    public function getNegativeRatingsAttribute()
    {
        return $this->negativeRatings()->count();
    }

    public function getUnreadOrdersAttribute()
    {
        return $this->sales()->unreplied()->count();
    }

    public function getRepliedOrdersCountAttribute()
    {
        return $this->sales()->replied()->count();
    }

    public function getTimeToReplyAttribute()
    {
        return $this->sales()->selectRaw('ROUND(AVG(TIMESTAMPDIFF(MINUTE, timestamp, replied))) AS time_to_reply, `location-date`, count(*) as count_of_sales, "m" as unit')->replied()->first()->makeHidden('location-date');
    }

    public function getProfilepicAttribute()
    {
        if (! isset($this->attributes['profilepic'])) {
            return 'https://justbookr.com/images/JBicon.svg';
        }
        str_replace('http://', 'https://', $this->attributes['profilepic']);

        return str_replace('https://s3-eu-west-1.amazonaws.com/justbookrbucket/images/Uploads', 'https://content.justbookr.com', $this->attributes['profilepic']);
    }

    public function isSuperAdmin()
    {
        if ($this->{'user-id'} == config('app.admin_id')) {
            return true;
        }

        return false;
    }
}
