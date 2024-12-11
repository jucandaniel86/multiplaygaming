<?php

  namespace App\Enums;

  enum ArticleTypesEnum: string
  {
    case NEWS = "news";
    case ARTICLES = "articles";
    case PROMO_GAMES = "promo_games";

    public function description(): string
    {
      return match ($this) {
        self::NEWS => 'News',
        self::ARTICLES => 'Articles',
        self::PROMO_GAMES => 'Promo Games',
      };
    }
  }
