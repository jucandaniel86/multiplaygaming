<?php

  namespace App\Enums;

  enum PartnerTypesEnum: string
  {
    case STUDIOS = "studios";
    case MEDIA = "media";
    case AFFILIATES = "affiliates";

    public function description(): string
    {
      return match ($this) {
        self::STUDIOS => 'studios',
        self::MEDIA => 'media',
        self::AFFILIATES => 'affiliates',
      };
    }
  }
