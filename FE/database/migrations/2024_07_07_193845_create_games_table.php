<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  use App\Enums\VolatilityEnum;
  use App\Enums\StatusEnum;

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('games', function (Blueprint $table) {
        $table->unsignedBigInteger('id')->autoIncrement();
        #general
        $table->string('game_name');
        $table->integer('created_by')->default(0)->nullable();
        $table->string('game_id')->nullable();
        $table->integer('category_id')->default(-1)->nullable();
        $table->tinyInteger('featured_game')->default(0)->nullable();
        #description
        $table->text('short_description')->nullable();
        $table->text('description')->nullable();
        #features
        $table->enum('volatility', array_column(VolatilityEnum::cases(), 'value')
        )->default(VolatilityEnum::MEDIUM->value);
        $table->decimal('rtp', 10, 2)->default(0)->nullable();
        $table->dateTime('release_date')->nullable();
        $table->string('lines')->nullable();
        $table->integer('fs_rate')->nullable();
        $table->decimal('hit_rate', 10, 2)->nullable();
        $table->decimal('max_multiplier', 10, 2)->nullable();
        $table->decimal('max_win', 10, 2)->nullable();
        $table->enum('game_status', array_column(StatusEnum::cases(), 'value')
        )->default(StatusEnum::DRAFT->value);
        #seo
        $table->string('slug');
        $table->string('meta_description')->nullable();
        $table->string('meta_title')->nullable();
        #deleted
        $table->tinyInteger('DELETED')->default(0)->nullable();
        $table->dateTime('deleted_at')->nullable();
        $table->integer('deleted_by')->nullable()->default(0);
        #external urls
        $table->text('demo_url')->nullable();
        $table->text('trailer_url')->nullable();
        $table->text('rules_url')->nullable();
        #demo section
        $table->string('demo_text_header')->nullable();
        $table->string('demo_img')->nullable();

        $table->string('thumbnail')->nullable();
        $table->string('description_img')->nullable();
        #timestamps
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('games');
    }
  };
