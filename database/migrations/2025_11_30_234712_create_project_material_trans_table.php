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
        Schema::create('project_material_trans', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('project_material_id');
            $table->integer('quantity');
            $table->string('type'); // in / out
            $table->string('status'); // pending / approved
            $table->string('note')->nullable();
            $table->foreignUlid('request_by');
            $table->foreignUlid('approved_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_material_trans');
    }
};
