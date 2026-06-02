<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name', 'dojo_id', 'instructor_id', 'description',
        'schedule', 'max_students', 'level', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function dojo()
    {
        return $this->belongsTo(Dojo::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments')
            ->withPivot('enrolled_at', 'status')
            ->withTimestamps();
    }
}
