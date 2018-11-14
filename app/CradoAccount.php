<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CradoAccount extends Model
{
    protected $table = "crado_accounts";
    
    protected $guarded = ['id'];
}
