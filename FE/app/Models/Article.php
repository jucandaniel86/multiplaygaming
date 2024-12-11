<?php

  namespace App\Models;

  use App\Enums\StatusEnum;
  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasOne;
  use Illuminate\Support\Str;

  class Article extends Model
  {
    use HasFactory;

    protected $casts = [
      'article_status' => StatusEnum::class
    ];

    protected $fillable = ['slug', 'thumbnail_url', 'banner_url', 'title', 'article_status', 'created_by', 'meta_title', 'article_type'];

    protected $appends = ['thumbnail', 'banner'];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->title);
      });
    }

    public function category(): HasOne
    {
      return $this->hasOne(ArticleCategory::class, 'id', 'category_id');
    }

    public function getThumbnailAttribute()
    {
      if (!$this->thumbnail_url) return '';

      return url(config('website.paths.articles') . $this->thumbnail_url);
    }

    public function getBannerAttribute()
    {
      if (!$this->banner_url) return '';

      return url(config('website.paths.articles') . $this->banner_url);
    }
  }
