<?php

namespace App\Models;

use App\Components\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['email', 'password', 'name', 'status', 'note'];

    protected $hidden = ['password', 'remember_token'];

    protected $guarded = ['id', 'created_at', 'updated_at', 'status'];

    const STATUS = [
        'deleted' => 0,
        'active' => 1,
        'blocked' => 2,
        'password_reset' => 3
    ];

}
