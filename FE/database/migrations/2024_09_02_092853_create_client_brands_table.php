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
      Schema::create('client_brands', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->integer('client_id');
        $table->text('brand_url')->nullable();
        $table->string('brand_rgs_id')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('client_brands');
    }
  };
