<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class Cv extends Model
  {
    use HasFactory;

    protected $appends = ['cv_url'];

    public function getCvUrlAttribute()
    {
      if ($this->cv !== "") {
        return url(config('website.paths.cvs') . $this->cv);
      }
      return '';
    }
  }
