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
        Schema::create('projects', function (Blueprint $table) {
            $table->ulid('id')->primary();

            // DATA DIRI
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->string('nik')->unique();
            $table->string('kecamatan');
            $table->string('desa_kelurahan');
            $table->text('alamat_lengkap');
            $table->string('no_whatsapp');
            $table->string('status_kepemilikan');
            $table->string('status_tanah');
            $table->string('pernah_bantuan');
            $table->string('tahun_dihuni');

            // KONDISI KELUARGA
            $table->string('jumlah_anggota_keluarga');
            $table->string('anggota_rentan');
            $table->string('terdaftar_bansos');
            $table->string('jenis_bantuan')->nullable();
            $table->string('nama_suami');
            $table->string('status_suami');
            $table->string('upah_suami');
            $table->string('pekerjaan_suami');
            $table->text('kondisi_khusus_suami');
            $table->string('nama_istri');
            $table->string('status_istri');
            $table->string('upah_istri');
            $table->string('pekerjaan_istri');
            $table->text('kondisi_khusus_istri');
            $table->string('jumlah_anak');
            $table->string('pendidikan_anak');
            $table->text('kondisi_khusus_anak');

            // KONDISI RUMAH
            $table->string('kondisi_atap');
            $table->string('kondisi_dinding');
            $table->string('kondisi_lantai');
            $table->string('luas_bangunan');
            $table->string('ventilasi_pencahayaan');
            $table->string('kamar_mandi_sanitasi');
            $table->string('rawan_banjir_longsor');
            $table->string('sedang_sengketa');
            $table->string('daya_listrik');
            $table->string('sumber_air');
            $table->text('catatan_khusus');

            // DOKUMENTASI
            $table->string('link_google_maps');
            $table->string('foto_ktp');
            $table->string('foto_kk');
            $table->string('foto_tampak_depan');
            $table->string('foto_tampak_samping')->nullable();
            $table->string('foto_dalam_rumah');
            $table->string('foto_toilet')->nullable();
            $table->string('foto_dapur')->nullable();
            $table->string('foto_petugas_survey');

            $table->string('status')->default('draft');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
