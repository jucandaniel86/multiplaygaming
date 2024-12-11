<?php

  namespace Database\Factories;

  use App\Enums\ArticleTypesEnum;
  use App\Enums\StatusEnum;
  use Illuminate\Database\Eloquent\Factories\Factory;
  use Illuminate\Support\Str;

  /**
   * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carrer>
   */
  class CarrerFactory extends Factory
  {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
      return [
        "job_title" => $this->faker->text(30),
        "slug" => Str::slug($this->faker->text(30)),
        "department_id" => $this->faker->randomElement([2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13]),
        "job_status" => StatusEnum::PUBLISHED->value,
        "content" => $this->faker->text(500),
        "required_experience" => $this->faker->text(10),
        "employment_type" => $this->faker->randomElement(['full-time', 'part-time']),
        "role_overview" => $this->faker->text(500),
        "responsibilities" => $this->faker->text(500),
        "requirements" => $this->faker->text(500),
        "work_conditions" => $this->faker->text(500),
        "is_active" => 1,
        "created_by" => 1,
        "created_at" => now(),
      ];
    }
  }
