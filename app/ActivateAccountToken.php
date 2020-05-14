<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivateAccountToken extends Model
{
    protected $fillable = ['token', 'user_id'];
}
