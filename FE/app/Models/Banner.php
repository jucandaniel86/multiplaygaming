<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Banner extends Model
  {
    use HasFactory;

    protected $appends = ['slide_url'];
    protected $guarded = [];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->created_by = auth()->user()->id;
      });
    }

    public function getSlideUrlAttribute()
    {
      if (!$this->slide_file) return '';

      return url(config('website.paths.banners') . $this->slide_file);
    }
  }
