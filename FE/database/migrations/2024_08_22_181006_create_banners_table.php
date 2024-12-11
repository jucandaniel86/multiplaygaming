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
      Schema::create('banners', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->text('description')->nullable();
        $table->tinyInteger('is_active')->nullable()->default(0);
        $table->integer('created_by')->nullable();
        $table->string('slide_file')->nullable();
        $table->enum('slide_type', [
          'CLIENT_AREA', 'WEBSITE'
        ])->default('CLIENT_AREA')->nullable();
        $table->text('external_url')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('banners');
    }
  };
