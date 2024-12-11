<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Support\Str;

  class GameCategory extends Model
  {
    use HasFactory;

    protected $table = "game_categories";

    protected $fillable = ['slug', 'name', 'meta_title', 'is_active'];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->name);
      });
    }

    public function games(): HasMany
    {
      return $this->hasMany(Game::class, 'category_id', 'id');
    }
  }
