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
      Schema::create('exchanges', function (Blueprint $table) {
        $table->id();
        $table->dateTime('update_time')->nullable();
        $table->integer('api_timestamp')->nullable();
        $table->string('currency');
        $table->decimal('rate', 10, 2);
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('exchanges');
    }
  };