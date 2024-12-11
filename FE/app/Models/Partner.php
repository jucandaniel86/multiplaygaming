<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Partner extends Model
  {
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['logo_url'];

    public function getLogoUrlAttribute()
    {
      if (!$this->logo) return '';

      return url(config('website.paths.partners') . $this->logo);
    }
  }
