<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'dojo_id', 'title', 'specialization', 'bio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dojo()
    {
        return $this->belongsTo(Dojo::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'instructor_id');
    }
}
