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
      Schema::table('games', function (Blueprint $table) {
        $table->tinyInteger('is_featured')->default(0)->nullable();
        $table->tinyInteger('is_branded')->default(0)->nullable();
        $table->tinyInteger('is_coming_soon')->default(0)->nullable();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('games', function (Blueprint $table) {
        //
      });
    }
  };
