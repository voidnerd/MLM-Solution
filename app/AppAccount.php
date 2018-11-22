<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppAccount extends Model
{
    protected $table = "app_accounts";
    
    protected $guarded = ['id'];
}
