<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('article_categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('meta_title')->nullable();
        $table->string('meta_description')->nullable();
        $table->tinyInteger('is_active')->default(0)->nullable();
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
      Schema::dropIfExists('article_categories');
    }
  };
