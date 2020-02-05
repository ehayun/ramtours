<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $fillable = ['full_name','ip_address','email','phone','is_ban'];
}
