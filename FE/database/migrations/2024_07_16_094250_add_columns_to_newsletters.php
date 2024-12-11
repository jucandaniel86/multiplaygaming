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
      Schema::table('newsletters', function (Blueprint $table) {
        $table->tinyInteger('news_subscription')->default(0)->nullable();
        $table->tinyInteger('catalog_subscription')->default(0)->nullable();
        $table->tinyInteger('consultation_subscription')->default(0)->nullable();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('newsletters', function (Blueprint $table) {
        //
      });
    }
  };
