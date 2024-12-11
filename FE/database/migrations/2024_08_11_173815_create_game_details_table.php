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
      Schema::create('game_details', function (Blueprint $table) {
        $table->id();
        $table->integer('game_id');
        $table->string('game_symbols')->nullable();
        $table->string('bet_per_lines')->nullable();
        $table->string('max_total_bet')->nullable();
        $table->string('max_total_bet_ante')->nullable();
        $table->string('reels')->nullable();
        $table->string('rows')->nullable();
        $table->string('bet_multiplier')->nullable();
        $table->text('rtps')->nullable();
        $table->text('hit_frequency')->nullable();
        $table->string('devices')->nullable();
        $table->tinyInteger('has_replay')->default(0)->nullable();
        $table->tinyInteger('has_buy_spins')->default(0)->nullable();
        $table->tinyInteger('has_ante_bet')->default(0)->nullable();
        $table->string('game_string_id')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('game_details');
    }
  };
