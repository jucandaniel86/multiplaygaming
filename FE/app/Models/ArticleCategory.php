<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Support\Str;

  class ArticleCategory extends Model
  {
    use HasFactory;

    protected $fillable = ['slug', 'name', 'meta_title', 'is_active'];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->name);
      });
    }
  }
