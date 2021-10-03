<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User\User as ModelUser;

class User extends ModelUser
{
    //Sadly some vendors call this directly it's here just in case :D  Happy Coding!
}
