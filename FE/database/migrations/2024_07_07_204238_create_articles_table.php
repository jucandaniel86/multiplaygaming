<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  use App\Enums\ArticleTypesEnum;
  use App\Enums\StatusEnum;

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('articles', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->integer('created_by')->default(0)->nullable();
        $table->integer('category_id')->default(0)->nullable();
        $table->tinyInteger('is_highlighted')->default(0)->nullable();
        $table->text('content')->nullable();
        $table->text('short_content')->nullable();
        $table->dateTime('published_date');
        $table->enum('article_type', array_column(ArticleTypesEnum::cases(), 'value')
        )
          ->default(ArticleTypesEnum::ARTICLES->value)
          ->nullable();
        $table->enum('article_status', array_column(StatusEnum::cases(), 'value')
        )->default(StatusEnum::DRAFT->value);
        $table->string('thumbnail_url')->nullable();
        $table->string('banner_url')->nullable();
        $table->string('meta_title')->nullable();
        $table->string('meta_description')->nullable();
        $table->string('slug');
        $table->tinyInteger('DELETED')->default(0)->nullable();
        $table->dateTime('deleted_at')->nullable();
        $table->integer('deleted_by')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('articles');
    }
  };
