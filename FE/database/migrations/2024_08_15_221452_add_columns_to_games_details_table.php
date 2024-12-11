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
      Schema::table('game_details', function (Blueprint $table) {
        $table->tinyInteger('has_jackpot')->nullable();
        $table->tinyInteger('has_free_spins')->nullable();
        $table->tinyInteger('has_instant_bonus')->nullable();
        $table->string('min_total_bet')->nullable();
        $table->string('max_exposure')->nullable();
        $table->string('total_bet')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('game_details', function (Blueprint $table) {
        //
      });
    }
  };
