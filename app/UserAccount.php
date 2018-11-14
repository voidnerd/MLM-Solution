<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAccount extends Model
{
    
    protected $table = "user_accounts";

    protected $guarded = ['id'];

    
}
