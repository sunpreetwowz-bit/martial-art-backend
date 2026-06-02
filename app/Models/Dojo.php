<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dojo extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'city', 'phone', 'description'];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function instructors()
    {
        return $this->hasMany(Instructor::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassModel::class, 'dojo_id');
    }
}
