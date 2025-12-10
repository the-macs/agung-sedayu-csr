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
        Schema::create('project_weekly_reports', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('project_id');
            $table->integer('week_number'); // 1, 2, 3, 4
            $table->string('title');
            $table->string('focus');
            $table->json('checklists'); // Store completed checklist items
            $table->json('attachments'); // Store files for this week
            $table->text('notes')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->foreignUlid('reported_by')->nullable();
            $table->timestamps();

            // Ensure one report per week per project
            $table->unique(['project_id', 'week_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_weekly_reports');
    }
};
