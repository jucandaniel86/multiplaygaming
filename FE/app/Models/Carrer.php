<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Database\Eloquent\Relations\HasOne;
  use Illuminate\Support\Str;

  class Carrer extends Model
  {
    use HasFactory;

    protected $fillable = ['job_title', 'created_by', 'slug', 'content', 'department_id', 'is_active'];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->job_title);
      });
    }

    public function department(): HasOne
    {
      return $this->hasOne(Departments::class, 'id', 'department_id');
    }

    public function cvs(): HasMany
    {
      return $this->hasMany(Cv::class, 'job_id', 'id');
    }
  }
