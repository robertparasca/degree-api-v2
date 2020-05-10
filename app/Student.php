<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'full_name', 'email', 'unique_registration_number',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scholarships() {
        return $this->hasMany(Student::class, 'unique_registration_number', 'unique_registration_number');
    }

    public function tickets() {
        return $this->hasMany(Ticket::class, 'user_id', 'user_id');
    }
}
