<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\Project;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        $wizard = Wizard::make([
            // STEP 1: DATA DIRI
            Step::make('Data Diri')
                ->icon('heroicon-o-user')
                ->description('Informasi pribadi dan alamat')
                ->schema([
                    Section::make('Informasi Pribadi')
                        ->description('Data lengkap sesuai KTP')
                        ->schema([
                            TextInput::make('nama_lengkap')
                                ->required()
                                ->maxLength(255)
                                ->label('Nama Lengkap (Sesuai KTP)')
                                ->placeholder('Masukkan nama lengkap sesuai KTP'),
                            TextInput::make('nama_panggilan')
                                ->required()
                                ->maxLength(100)
                                ->placeholder('Masukkan nama panggilan'),
                            TextInput::make('nik')
                                ->required()
                                ->unique(ignoreRecord: true)
                                ->maxLength(16)
                                ->label('NIK')
                                ->placeholder('Masukkan 16 digit NIK'),
                        ])->columns(3),

                    Section::make('Alamat Tempat Tinggal')
                        ->description('Alamat sesuai KTP')
                        ->schema([
                            Select::make('kecamatan')
                                ->required()
                                ->options(Project::KECAMATAN)
                                ->searchable()
                                ->placeholder('Pilih kecamatan'),
                            TextInput::make('desa_kelurahan')
                                ->required()
                                ->maxLength(255)
                                ->label('Desa / Kelurahan')
                                ->placeholder('Masukkan nama desa/kelurahan'),
                            Textarea::make('alamat_lengkap')
                                ->required()
                                ->label('Alamat Lengkap (Sesuai KTP)')
                                ->placeholder('Masukkan alamat lengkap sesuai KTP')
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make('Kontak & Status Kepemilikan')
                        ->schema([
                            TextInput::make('no_whatsapp')
                                ->required()
                                ->tel()
                                ->maxLength(15)
                                ->label('No. WhatsApp')
                                ->placeholder('Contoh: 081234567890'),
                            Select::make('status_kepemilikan')
                                ->required()
                                ->options(Project::STATUS_KEPEMILIKAN)
                                ->placeholder('Pilih status kepemilikan'),
                            Select::make('status_tanah')
                                ->required()
                                ->options(Project::STATUS_TANAH)
                                ->placeholder('Pilih status tanah'),
                            Select::make('pernah_bantuan')
                                ->required()
                                ->options(Project::YA_TIDAK)
                                ->label('Apakah rumah pernah mendapatkan bantuan sebelumnya?')
                                ->placeholder('Pilih jawaban'),
                            TextInput::make('tahun_dihuni')
                                ->required()
                                ->numeric()
                                ->label('Sejak kapan rumah ini dihuni?'),
                        ])->columns(2),
                ]),

            // STEP 2: KONDISI KELUARGA
            Step::make('Kondisi Keluarga')
                ->icon('heroicon-o-users')
                ->description('Informasi kondisi keluarga')
                ->schema([
                    Section::make('Informasi Umum Keluarga')
                        ->schema([
                            TextInput::make('jumlah_anggota_keluarga')
                                ->required()
                                ->numeric()
                                ->label('Berapa jumlah anggota keluarga yang tinggal di rumah ini?')
                                ->placeholder('Masukkan jumlah anggota keluarga'),
                            Select::make('anggota_rentan')
                                ->required()
                                ->options(Project::ANGGOTA_RENTAN)
                                ->label('Apakah ada anggota keluarga rentan?')
                                ->placeholder('Pilih jika ada'),
                            Select::make('terdaftar_bansos')
                                ->required()
                                ->options(Project::YA_TIDAK)
                                ->label('Apakah terdaftar dalam penerima bantuan sosial lainnya?')
                                ->reactive()
                                ->placeholder('Pilih jawaban'),
                            Select::make('jenis_bantuan')
                                ->options(Project::JENIS_BANTUAN)
                                ->label('Jika iya, sebutkan jenis bantuan yang diperoleh')
                                ->placeholder('Pilih jenis bantuan')
                                ->visible(fn($get) => $get('terdaftar_bansos') === 'Ya'),
                        ])->columns(2),

                    Section::make('Data Suami')
                        ->schema([
                            TextInput::make('nama_suami')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Masukkan nama lengkap suami'),
                            Select::make('status_suami')
                                ->required()
                                ->options(Project::STATUS_HIDUP)
                                ->placeholder('Pilih status'),
                            TextInput::make('upah_suami')
                                ->required()
                                ->numeric(),
                            TextInput::make('pekerjaan_suami')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Masukkan pekerjaan suami'),
                            Textarea::make('kondisi_khusus_suami')
                                ->required()
                                ->label('Kondisi Khusus Suami')
                                ->placeholder('Deskripsi kondisi khusus suami jika ada')
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make('Data Istri')
                        ->schema([
                            TextInput::make('nama_istri')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Masukkan nama lengkap istri'),
                            Select::make('status_istri')
                                ->required()
                                ->options(Project::STATUS_HIDUP)
                                ->placeholder('Pilih status'),
                            TextInput::make('upah_istri')
                                ->required()
                                ->numeric(),
                            TextInput::make('pekerjaan_istri')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Masukkan pekerjaan istri'),
                            Textarea::make('kondisi_khusus_istri')
                                ->required()
                                ->label('Kondisi Khusus Istri')
                                ->placeholder('Deskripsi kondisi khusus istri jika ada')
                                ->columnSpanFull(),
                        ])->columns(2),

                    Section::make('Data Anak')
                        ->schema([
                            TextInput::make('jumlah_anak')
                                ->required()
                                ->numeric()
                                ->placeholder('Masukkan jumlah anak'),
                            TextInput::make('pendidikan_anak')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('Contoh: SD, SMP, SMA, Kuliah, dll'),
                            Textarea::make('kondisi_khusus_anak')
                                ->required()
                                ->label('Kondisi Khusus Anak')
                                ->placeholder('Deskripsi kondisi khusus anak jika ada')
                                ->columnSpanFull(),
                        ])->columns(2),
                ]),

            // STEP 3: KONDISI RUMAH
            Step::make('Kondisi Rumah')
                ->icon('heroicon-o-home')
                ->description('Kondisi fisik rumah')
                ->schema([
                    Section::make('Kondisi Fisik Bangunan')
                        ->schema([
                            Select::make('kondisi_atap')
                                ->required()
                                ->options(Project::KONDISI_ATAP)
                                ->label('Atap')
                                ->placeholder('Pilih kondisi atap'),
                            Select::make('kondisi_dinding')
                                ->required()
                                ->options(Project::KONDISI_DINDING)
                                ->label('Dinding')
                                ->placeholder('Pilih kondisi dinding'),
                            Select::make('kondisi_lantai')
                                ->required()
                                ->options(Project::KONDISI_LANTAI)
                                ->label('Lantai')
                                ->placeholder('Pilih kondisi lantai'),
                            TextInput::make('luas_bangunan')
                                ->required()
                                ->maxLength(50)
                                ->label('Luas Bangunan')
                                ->suffix('m²')
                                ->placeholder('Masukkan luas bangunan'),
                        ])->columns(2),

                    Section::make('Fasilitas & Utilitas')
                        ->schema([
                            Select::make('ventilasi_pencahayaan')
                                ->required()
                                ->options(Project::VENTILASI_PENCAHAYAAN)
                                ->label('Ventilasi dan Pencahayaan')
                                ->placeholder('Pilih kondisi'),
                            Select::make('kamar_mandi_sanitasi')
                                ->required()
                                ->options(Project::KAMAR_MANDI_SANITASI)
                                ->label('Kamar Mandi & Sanitasi')
                                ->placeholder('Pilih kondisi'),
                            Select::make('daya_listrik')
                                ->required()
                                ->options(Project::DAYA_LISTRIK)
                                ->placeholder('Pilih daya listrik'),
                            Select::make('sumber_air')
                                ->required()
                                ->options(Project::SUMBER_AIR)
                                ->placeholder('Pilih sumber air'),
                        ])->columns(2),

                    Section::make('Lingkungan & Legalitas')
                        ->schema([
                            Select::make('rawan_banjir_longsor')
                                ->required()
                                ->options(Project::YA_TIDAK)
                                ->label('Apakah rumah rawan banjir / longsor?')
                                ->placeholder('Pilih jawaban'),
                            Select::make('sedang_sengketa')
                                ->required()
                                ->options(Project::YA_TIDAK)
                                ->label('Apakah rumah sedang dalam sengketa?')
                                ->placeholder('Pilih jawaban'),
                        ])->columns(2),

                    Section::make('Catatan Tambahan')
                        ->schema([
                            Textarea::make('catatan_khusus')
                                ->required()
                                ->label('Catatan Khusus (Informasi Tambahan)')
                                ->placeholder('Masukkan catatan khusus atau informasi tambahan tentang kondisi rumah')
                                ->columnSpanFull()
                                ->rows(4),
                        ]),
                ]),

            // STEP 4: DOKUMENTASI
            Step::make('Dokumentasi')
                ->icon('heroicon-o-camera')
                ->description('Upload dokumen dan foto')
                ->schema([
                    Section::make('Lokasi')
                        ->schema([
                            TextInput::make('link_google_maps')
                                ->required()
                                ->url()
                                ->label('Link Google Maps')
                                ->placeholder('https://maps.google.com/...')
                                ->columnSpanFull()
                                ->helperText('Salin link Google Maps lokasi rumah'),
                        ]),

                    Section::make('Dokumen Wajib')
                        ->description('Dokumen yang harus diupload')
                        ->schema([
                            FileUpload::make('foto_ktp')
                                ->required()
                                ->image()
                                ->directory('projects/ktp')
                                ->maxSize(2048)
                                ->label('Foto KTP')
                                ->helperText('Upload foto KTP yang jelas dan terbaca'),
                            FileUpload::make('foto_kk')
                                ->required()
                                ->image()
                                ->directory('projects/kk')
                                ->maxSize(2048)
                                ->label('Foto KK')
                                ->helperText('Upload foto Kartu Keluarga yang jelas'),
                            FileUpload::make('foto_tampak_depan')
                                ->required()
                                ->image()
                                ->directory('projects/tampak-depan')
                                ->maxSize(2048)
                                ->label('Foto Tampak Depan')
                                ->helperText('Upload foto tampak depan rumah'),
                            FileUpload::make('foto_dalam_rumah')
                                ->required()
                                ->image()
                                ->directory('projects/dalam-rumah')
                                ->maxSize(2048)
                                ->label('Foto Dalam Rumah')
                                ->helperText('Upload foto kondisi dalam rumah'),
                            FileUpload::make('foto_petugas_survey')
                                ->required()
                                ->image()
                                ->directory('projects/survey')
                                ->maxSize(2048)
                                ->label('Foto Petugas Survey bersama Calon Penerima Manfaat')
                                ->helperText('Upload foto petugas survey bersama calon penerima manfaat'),
                        ])->columns(2),

                    Section::make('Dokumen Tambahan')
                        ->description('Dokumen pendukung (opsional)')
                        ->schema([
                            FileUpload::make('foto_tampak_samping')
                                ->image()
                                ->directory('projects/tampak-samping')
                                ->maxSize(2048)
                                ->label('Foto Tampak Samping')
                                ->helperText('Upload foto tampak samping rumah (opsional)'),
                            FileUpload::make('foto_toilet')
                                ->image()
                                ->directory('projects/toilet')
                                ->maxSize(2048)
                                ->label('Foto Toilet')
                                ->helperText('Upload foto kondisi toilet (opsional)'),
                            FileUpload::make('foto_dapur')
                                ->image()
                                ->directory('projects/dapur')
                                ->maxSize(2048)
                                ->label('Foto Dapur')
                                ->helperText('Upload foto kondisi dapur (opsional)'),
                        ])->columns(2),
                ]),
        ])
            // ->skippable(fn($context) => $context !== 'create')
            ->skippable()
            ->persistStepInQueryString()
            ->columnSpanFull();

        if (request()->routeIs('*create')) { // or $this->getContext() === 'create' if inside Livewire
            $wizard->submitAction(
                Action::make('submit')
                    ->label('Simpan Data Project')
                    ->icon('heroicon-o-check')
                    ->action('create')
            );
        }

        return $schema
            ->components([
                $wizard
            ]);
    }
}
