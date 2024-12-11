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
      Schema::create('announces', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug');
        $table->string('subtitle')->nullable();
        $table->text('description')->nullable();
        $table->tinyInteger('is_active')->nullable()->default(0);
        $table->text('link')->nullable();
        $table->dateTime('started_at')->nullable();
        $table->dateTime('ended_at')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('announces');
    }
  };
