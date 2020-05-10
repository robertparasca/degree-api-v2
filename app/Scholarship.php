<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'unique_registration_number', 'amount'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
