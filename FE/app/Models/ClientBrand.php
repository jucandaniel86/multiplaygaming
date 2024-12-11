<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;
  use Illuminate\Database\Eloquent\Relations\HasOne;

  class ClientBrand extends Model
  {
    use HasFactory;

    protected $guarded = [];

    public function client(): HasOne
    {
      return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function taxes(): HasMany
    {
      return $this->hasMany(ClientBrandsTaxes::class, 'id', 'brand_id');
    }
  }
