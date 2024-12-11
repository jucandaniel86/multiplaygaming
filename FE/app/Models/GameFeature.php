<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasOne;

  class GameFeature extends Model
  {
    use HasFactory;

    protected $table = "game_features";
    public $timestamps = false;

    public function game(): HasOne
    {
      return $this->hasOne(Game::class, 'id', 'game_id');
    }

    public function feature(): HasOne
    {
      return $this->hasOne(Feature::class, 'id', 'feature_id');
    }
  }
