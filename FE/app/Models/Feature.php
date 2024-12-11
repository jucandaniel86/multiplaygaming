<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Str;

  class Feature extends Model
  {
    use HasFactory;

    protected $fillable = ['slug', 'name', 'long_name', 'content', 'is_active', 'is_highlighted'];


    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->name);
      });
    }
  }
