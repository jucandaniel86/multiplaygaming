<?php

  namespace App\Enums;

  enum VolatilityEnum: string
  {
    case NA = 'na';
    case HIGH = "high";
    case LOW = "low";
    case MEDIUM = "medium";
    case MEDIUM_LOW = "medium_low";
    case MEDIUM_HIGH = "medium_high";
    case VERY_HIGH = "very_high";

    public function description(): string
    {
      return match ($this) {
        self::NA => 'N/A',
        self::HIGH => 'High',
        self::LOW => 'Low',
        self::MEDIUM => 'Medium',
        self::MEDIUM_LOW => 'Medium Low',
        self::MEDIUM_HIGH => 'Medium High',
        self::VERY_HIGH => 'Very High',
      };
    }

    public function points(): string
    {
      return match ($this) {
        self::VERY_HIGH => 6,
        self::HIGH => 5,
        self::MEDIUM_HIGH => 4,
        self::MEDIUM => 3,
        self::MEDIUM_LOW => 2,
        self::LOW => 1,
        self::NA => 0,
      };
    }

    public static function fromValue($value): string
    {
      foreach (self::cases() as $status) {
        if ($value === $status->value) {
          return $status->description();
        }
      }
      throw new \ValueError("$value is not a valid backing value for enum " . self::class);
    }

    public static function valuePoints($value): string
    {
      foreach (self::cases() as $status) {
        if ($value === $status->value) {
          return $status->points();
        }
      }
      throw new \ValueError("$value is not a valid backing value for enum " . self::class);
    }
  }
