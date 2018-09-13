<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = "user-id";
    public $timestamps = false;
    protected $fillable = ['name', 'surname', 'profilepic', 'email', 'uni-id'];
    protected $hidden = ['password', 'sess-id', 'last_ip_access', 'username', 'userlevel', 'user-tel', 'address', 'last_login', 'email'];

}
