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
      Schema::create('game_features', function (Blueprint $table) {
        $table->unsignedBigInteger('game_id');
        $table->unsignedBigInteger('feature_id');

        $table->foreign('game_id')->references('id')->on('games');
        $table->foreign('feature_id')->references('id')->on('features');

        $table->primary(['game_id', 'feature_id']);
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('game_features');
    }
  };
