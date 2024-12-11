<?php

  namespace App\Models;

  use Illuminate\Database\Eloquent\Factories\HasFactory;
  use Illuminate\Database\Eloquent\Model;
  use Illuminate\Database\Eloquent\Relations\HasMany;

  class Client extends Model
  {
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['clientCurrencies'];

    public function brands(): HasMany
    {
      return $this->hasMany(ClientBrand::class, 'client_id', 'id');
    }

    public function getClientCurrenciesAttribute(): array
    {
      if (!$this->currencies) return [];
      return json_decode($this->currencies) ?? [];
    }
  }
