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
        Schema::create('other_projects', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('code');
            $table->string('project_name');
            $table->string('nama_lembaga')->nullable();
            $table->string('penanggung_jawab');
            $table->string('no_whatsapp', 20);
            $table->text('alamat_lengkap');
            $table->string('link_google_maps');
            $table->string('photos')->nullable();

            $table->string('status')->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_projects');
    }
};
