<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $table = "train_schedule";
    
    protected $guarded = ['id'];
}
