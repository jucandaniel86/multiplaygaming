<?php

	namespace App\Enums;

	enum DownloadType: string
	{
		case LINK = "LINK";
		case FILE = "FILE";
		case ASSET = "ASSET";

		public function description(): string
		{
			return match ($this) {
				self::LINK => 'Link',
				self::FILE => 'File',
			};
		}
	}