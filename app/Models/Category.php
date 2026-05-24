<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted(): void
    {
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
