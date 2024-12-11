<?php

	namespace App\Models;

	use App\Enums\DownloadType;
	use Illuminate\Database\Eloquent\Factories\HasFactory;
	use Illuminate\Database\Eloquent\Model;
	use Illuminate\Database\Eloquent\Relations\HasOne;

	class GameDownload extends Model
	{
		use HasFactory;

		protected $guarded = [];

		protected $appends = ['download_url'];

		public function jurisdiction(): HasOne
		{
			return $this->hasOne(Jurisdiction::class, 'id', 'jurisdiction_id');
		}

		public function getDownloadUrlAttribute()
		{
			if ($this->download_type === DownloadType::FILE->value) {
				return url(config('website.paths.downloads') . $this->download_value);
			}
			if ($this->download_type === DownloadType::ASSET->value) {
				return url(config('website.paths.assets') . $this->game_id . '/' . $this->download_value);
			}

			return $this->download_value;
		}
	}