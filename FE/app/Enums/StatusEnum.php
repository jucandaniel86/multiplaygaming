<?php

  namespace App\Enums;

  enum StatusEnum: string
  {
    case DRAFT = "draft";
    case DELETED = "deleted";
    case PUBLISHED = "published";
    case PRIVATE = "private";

    public function description(): string
    {
      return match ($this) {
        self::DRAFT => 'Draft',
        self::DELETED => 'Deleted',
        self::PUBLISHED => 'Published',
        self::PRIVATE => 'Private',
      };
    }
  }
