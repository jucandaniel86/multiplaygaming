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
        $table->tinyInteger('homepage_slider')->nullable()->default(0);
        $table->string('homepage_slider_img')->nullable();
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
