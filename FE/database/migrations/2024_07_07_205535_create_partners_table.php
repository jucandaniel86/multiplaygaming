<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;

  use App\Enums\PartnerTypesEnum;

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('partners', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('external_url')->nullable();
        $table->string('logo')->nullable();
        $table->enum('partner_type', array_column(PartnerTypesEnum::cases(), 'value'))
          ->default(PartnerTypesEnum::STUDIOS->value)
          ->nullable();
        $table->tinyInteger('is_active')->default(0)->nullable();
        $table->integer('created_by')->default(0)->nullable();
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('partners');
    }
  };
