<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project = [
            'id' => '01ke4fdkwr63csvj5ms80b8rry',
            'code' => 'PRJ001',
            'nama_lengkap' => 'Esa Hadistra',
            'nama_panggilan' => 'Esa H',
            'nik' => '3172031009941004',
            'kecamatan' => 'Teluknaga',
            'desa_kelurahan' => 'Jakarta',
            'alamat_lengkap' => 'XXyZ',
            'no_whatsapp' => '23123123',
            'status_kepemilikan' => 'Milik Sendiri',
            'status_tanah' => 'SHM (Sertifikat Hak Milik)',
            'pernah_bantuan' => 'Ya',
            'tahun_dihuni' => 2020,
            'jumlah_anggota_keluarga' => 3,
            'anggota_rentan' => 'Yatim/Piatu',
            'terdaftar_bansos' => 'Ya',
            'jenis_bantuan' => null,

            'nama_suami' => 'Esa',
            'status_suami' => 'Hidup',
            'upah_suami' => 123123123,
            'pekerjaan_suami' => 'sasddasd',
            'kondisi_khusus_suami' => 'asdadad',

            'nama_istri' => 'asdasdasd',
            'status_istri' => 'Hidup',
            'upah_istri' => 12312312312,
            'pekerjaan_istri' => 'sadasdasd',
            'kondisi_khusus_istri' => 'maslckmsdklacmsad',

            'jumlah_anak' => 2,
            'pendidikan_anak' => 'asdasd',
            'kondisi_khusus_anak' => 'asdasd',

            'kondisi_atap' => 'Bocor Sebagian',
            'kondisi_dinding' => 'Tembok Retak',
            'kondisi_lantai' => 'Semen',
            'luas_bangunan' => 12312312,
            'ventilasi_pencahayaan' => 'Cukup',
            'kamar_mandi_sanitasi' => 'Layak',
            'rawan_banjir_longsor' => 'Tidak',
            'sedang_sengketa' => 'Ya',
            'daya_listrik' => 900,
            'sumber_air' => 'Sumur Gali',

            'catatan_khusus' => 'asdasdasd',
            'link_google_maps' => 'https://google.com/esa',

            'foto_ktp' => 'projects/ktp/01KE4FDKWK2CBVZZ0H3S31BGBP.jpeg',
            'foto_kk' => 'projects/kk/01KE4FDKWMY4W1FB1373RPFKBW.jpeg',
            'foto_tampak_depan' => 'projects/tampak-depan/01KE4FDKWMY4W1FB1373RPFKBX.jpeg',
            'foto_tampak_samping' => null,
            'foto_dalam_rumah' => 'projects/dalam-rumah/01KE4FDKWND307ST79XK0PZ27E.jpeg',
            'foto_toilet' => null,
            'foto_dapur' => null,
            'foto_petugas_survey' => 'projects/survey/01KE4FDKWND307ST79XK0PZ27F.jpeg',

            'status' => 'ongoing',
            'is_active' => 1,

            'created_at' => '2026-01-04 19:23:55',
            'updated_at' => '2026-01-04 20:55:03',
        ];

        Project::create($project);
    }
}
