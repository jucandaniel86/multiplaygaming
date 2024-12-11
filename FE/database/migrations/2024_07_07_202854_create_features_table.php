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
      Schema::create('features', function (Blueprint $table) {
        $table->unsignedBigInteger('id')->autoIncrement();
        $table->string('name');
        $table->string('slug');
        $table->string('long_name')->nullable();
        $table->text('content')->nullable();
        $table->tinyInteger('is_active')->default(0)->nullable();
        $table->tinyInteger('is_highlighted')->default(0)->nullable();
        $table->tinyInteger('DELETED')->default(0)->nullable();
        $table->dateTime('deleted_at')->nullable();
        $table->integer('deleted_by')->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('features');
    }
  };


