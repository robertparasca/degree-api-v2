<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'unique_registration_number', 'amount', 'type'
    ];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
