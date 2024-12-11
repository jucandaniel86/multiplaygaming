<?php

  namespace App\Models;

  use App\Enums\VolatilityEnum;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\BelongsToMany;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Database\Eloquent\Relations\HasOne;
  use Illuminate\Support\Str;

  class Game extends Model
  {
    use HasFactory;

    protected $casts = [
      'volatility' => VolatilityEnum::class
    ];

    protected $guarded = [];

    protected $rules = [
      'game_name' => 'required|string|max:255',
    ];

    protected $appends = ['thumbnail_url', 'demo_img_url', 'description_img_url', 'thumbnail_small_url'];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->game_name);
      });
    }

    public function category(): HasOne
    {
      return $this->hasOne(GameCategory::class, 'id', 'category_id');
    }


    public function features(): BelongsToMany
    {
      return $this->belongsToMany(Feature::class, 'game_features', 'game_id', 'feature_id')->withPivot('content');
    }

    public function gallery(): HasMany
    {
      return $this->hasMany(GamePicture::class, 'game_id', 'id');
    }

    public function details(): HasOne
    {
      return $this->hasOne(GameDetails::class, 'game_id', 'id');
    }

    public function downloads(): HasMany
    {
      return $this->hasMany(GameDownload::class, 'game_id', 'id');
    }

    public function jurisdictions(): BelongsToMany
    {
      return $this->belongsToMany(Jurisdiction::class, 'games_jurisdiction', 'game_id', 'jurisdiction_id');
    }

    public function getThumbnailUrlAttribute()
    {
      if (!$this->thumbnail) return '';

      return url(config('website.paths.games') . $this->thumbnail);
    }

    public function getThumbnailSmallUrlAttribute()
    {
      if (!$this->thumbnail_small) return '';

      return url(config('website.paths.games') . $this->thumbnail_small);
    }

    public function getDemoImgUrlAttribute()
    {
      if (!$this->demo_img) return '';

      return url(config('website.paths.games') . $this->demo_img);
    }

    public function getDescriptionImgUrlAttribute()
    {
      if (!$this->description_img) return '';

      return url(config('website.paths.games') . $this->description_img);
    }


  }
