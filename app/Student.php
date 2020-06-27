<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'birth_name',
        'father_name_initial',
        'unique_registration_number',
        'group',
        'active_year',
        'field_of_study',
        'program_of_study',
        'admission_grade',
        'admission_year',
        'start_year',
        'is_paying_tax',
        'user_id',
        'cycle_of_study',
        'language',
        'is_ID'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Student::class, 'unique_registration_number', 'unique_registration_number');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id', 'user_id');
    }
}
