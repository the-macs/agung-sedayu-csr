<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('other_project_weekly_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('other_project_id');
            $table->integer('week_number'); // 1, 2, 3, 4
            $table->string('title');
            $table->string('focus');
            $table->json('photos')->nullable();
            $table->text('notes')->nullable();
            $table->ulid('reported_by')->nullable();
            $table->timestamps();

            // Ensure one report per week per project
            $table->unique(['other_project_id', 'week_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_project_weekly_reports');
    }
};
