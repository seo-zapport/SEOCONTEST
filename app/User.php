<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function status()
    {
        return $this->belongsToMany(cseo_statuses::class,'cseo_role_accesses');
    }

    public function media()
    {
        return $this->belongsToMany(cseo_media::class,'cseo_role_accesses');

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "cseo_accounts";

    protected $fillable = [
        'first_name','last_name', 'email', 'password','account_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
