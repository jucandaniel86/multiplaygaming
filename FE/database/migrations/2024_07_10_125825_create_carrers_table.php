<?php

  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  use App\Enums\StatusEnum;

  return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('carrers', function (Blueprint $table) {
        $table->id();
        $table->string('job_title');
        $table->string('slug');
        $table->enum('job_status', array_column(StatusEnum::cases(), 'value')
        )->default(StatusEnum::DRAFT->value);
        $table->text('content')->nullable();
        $table->integer('department_id')->nullable();
        $table->string('required_experience')->nullable();
        $table->enum('employment_type', ['part-time', 'full-time'])->nullable();
        $table->text('role_overview')->nullable();
        $table->text('responsibilities')->nullable();
        $table->text('requirements')->nullable();
        $table->text('work_conditions')->nullable();
        $table->tinyInteger('is_active');
        $table->integer('created_by');
        $table->tinyInteger('DELETED')->default(0)->nullable();
        $table->dateTime('deleted_at')->nullable();
        $table->integer('deleted_by')->nullable()->default(0);

        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::dropIfExists('carrers');
    }
  };
