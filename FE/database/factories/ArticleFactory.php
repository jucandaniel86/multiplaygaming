<?php

  namespace Database\Factories;

  use App\Enums\ArticleTypesEnum;
  use App\Enums\StatusEnum;
  use Illuminate\Database\Eloquent\Factories\Factory;
  use Illuminate\Support\Str;

  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
   */
  class ArticleFactory extends Factory
  {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        "title" => $this->faker->text(100),
        "slug" => Str::slug($this->faker->text(200)),
        "category_id" => 1,
        "content" => $this->faker->text(1500),
        "short_content" => $this->faker->text(1000),
        "published_date" => now(),
        "article_type" => ArticleTypesEnum::PROMO_GAMES->value,
        "article_status" => StatusEnum::PUBLISHED->value,
        "thumbnail_url" => "article-title-test-thumbnail_TKY9d.webp"
      ];
    }
  }
