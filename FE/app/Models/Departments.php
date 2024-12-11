<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Support\Str;

  class Departments extends Model
  {
    use HasFactory;

    protected $fillable = ['name', 'is_active'];

    protected static function boot()
    {
      parent::boot();

      static::creating(function ($question) {
        $question->slug = Str::slug($question->title);
      });
    }

    public function jobs(): HasMany
    {
      return $this->hasMany(Carrer::class, 'department_id', 'id');
    }
  }
