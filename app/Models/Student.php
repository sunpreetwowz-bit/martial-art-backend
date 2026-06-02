<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dojo_id', 'belt_level_id', 'date_of_birth', 'join_date', 'emergency_contact', 'notes'];

    protected $casts = [
        'date_of_birth' => 'date',
        'join_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dojo()
    {
        return $this->belongsTo(Dojo::class);
    }

    public function beltLevel()
    {
        return $this->belongsTo(BeltLevel::class, 'belt_level_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'enrollments')->withPivot('enrolled_at', 'status')->withTimestamps();
    }
}
