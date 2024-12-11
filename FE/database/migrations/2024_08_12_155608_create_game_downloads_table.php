<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  use App\Enums\{DownloadType};

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('game_downloads', function (Blueprint $table) {
        $table->id();
        $table->integer('game_id');
        $table->enum('download_type', array_column(DownloadType::cases(), 'value')
        )->default(DownloadType::FILE->value);
        $table->text('download_value')->nullable();
        $table->integer('jurisdiction_id')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('game_downloads');
    }
  };
