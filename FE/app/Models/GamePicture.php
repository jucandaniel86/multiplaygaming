<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;

  class GamePicture extends Model
  {
    use HasFactory;

    protected $appends = ['thumbnail'];

    public function getThumbnailAttribute()
    {
      if (!$this->thumbnail_url) return '';

      return url(config('website.paths.games') . $this->game_id . '/' . $this->thumbnail_url);
    }
  }
