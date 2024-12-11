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
      Schema::create('game_pictures', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('game_id');
        $table->string('name')->nullable();
        $table->string('thumbnail_url');
        $table->string('details')->nullable();
        $table->integer('order_index')->index();

        $table->foreign('game_id')->references('id')->on('games');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('game_pictures');
    }
  };
