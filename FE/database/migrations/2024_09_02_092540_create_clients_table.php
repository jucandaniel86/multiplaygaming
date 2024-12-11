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
      Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('legal_name')->nullable();
        $table->tinyInteger('regulated')->default(0)->nullable();
        $table->integer('country_id');
        $table->decimal('tax', 10, 2)->default(0)->nullable();
        $table->tinyInteger('rev_share')->default(0)->nullable();
        $table->text('currencies')->nullable();
        $table->decimal('bet_limits', 10, 2)->default(0)->nullable();
        $table->string('client_rgs_id')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('clients');
    }
  };
