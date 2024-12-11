<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasOne;

  class ClientBrandsTaxes extends Model
  {
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function country(): HasOne
    {
      return $this->hasOne(Country::class, 'ID', 'country_id');
    }

    public function brand(): HasOne
    {
      return $this->hasOne(ClientBrand::class, 'id', 'brand_id');
    }
  }
