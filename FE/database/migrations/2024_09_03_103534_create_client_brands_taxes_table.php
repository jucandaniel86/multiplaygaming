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
      Schema::create('client_brands_taxes', function (Blueprint $table) {
        $table->id();
        $table->integer('brand_id');
        $table->integer('country_id');
        $table->string('brand_rgs_id');
        $table->integer('tax');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('client_brands_taxes');
    }
  };
