<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ProjectInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Data Diri')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Informasi Pribadi')
                                    ->description('Data lengkap sesuai KTP')
                                    ->schema([
                                        TextEntry::make('nama_lengkap')
                                            ->label('Nama Lengkap (Sesuai KTP)'),
                                        TextEntry::make('nama_panggilan')
                                            ->label('Nama Panggilan'),
                                        TextEntry::make('nik')
                                            ->label('NIK')
                                            ->copyable()
                                            ->copyMessage('NIK disalin ke clipboard'),
                                    ])->columns(3),

                                Section::make('Alamat Tempat Tinggal')
                                    ->description('Alamat sesuai KTP')
                                    ->schema([
                                        TextEntry::make('kecamatan')
                                            ->label('Kecamatan'),
                                        TextEntry::make('desa_kelurahan')
                                            ->label('Desa / Kelurahan'),
                                        TextEntry::make('alamat_lengkap')
                                            ->label('Alamat Lengkap')
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Section::make('Kontak & Status Kepemilikan')
                                    ->schema([
                                        TextEntry::make('no_whatsapp')
                                            ->label('No. WhatsApp')
                                            ->copyable(),
                                        TextEntry::make('status_kepemilikan')
                                            ->label('Status Kepemilikan'),
                                        TextEntry::make('status_tanah')
                                            ->label('Status Tanah'),
                                        TextEntry::make('pernah_bantuan')
                                            ->label('Pernah Bantuan?'),
                                        TextEntry::make('tahun_dihuni')
                                            ->label('Tahun Dihuni'),
                                    ])->columns(2),
                            ]),

                        Tab::make('Kondisi Keluarga')
                            ->icon('heroicon-o-users')
                            ->schema([
                                Section::make('Informasi Umum Keluarga')
                                    ->schema([
                                        TextEntry::make('jumlah_anggota_keluarga')
                                            ->label('Jumlah Anggota Keluarga'),
                                        TextEntry::make('anggota_rentan')
                                            ->label('Anggota Rentan'),
                                        TextEntry::make('terdaftar_bansos')
                                            ->label('Terdaftar Bansos?'),
                                        TextEntry::make('jenis_bantuan')
                                            ->label('Jenis Bantuan')
                                            ->visible(fn($record) => $record->terdaftar_bansos === 'Ya'),
                                    ])->columns(2),

                                Section::make('Data Suami')
                                    ->schema([
                                        TextEntry::make('nama_suami')
                                            ->label('Nama Suami'),
                                        TextEntry::make('status_suami')
                                            ->label('Status'),
                                        TextEntry::make('upah_suami')
                                            ->label('Upah')
                                            ->money('IDR'),
                                        TextEntry::make('pekerjaan_suami')
                                            ->label('Pekerjaan'),
                                        TextEntry::make('kondisi_khusus_suami')
                                            ->label('Kondisi Khusus Suami')
                                            ->columnSpanFull()
                                            ->html(),
                                    ])->columns(2),

                                Section::make('Data Istri')
                                    ->schema([
                                        TextEntry::make('nama_istri')
                                            ->label('Nama Istri'),
                                        TextEntry::make('status_istri')
                                            ->label('Status'),
                                        TextEntry::make('upah_istri')
                                            ->label('Upah')
                                            ->money('IDR'),
                                        TextEntry::make('pekerjaan_istri')
                                            ->label('Pekerjaan'),
                                        TextEntry::make('kondisi_khusus_istri')
                                            ->label('Kondisi Khusus Istri')
                                            ->columnSpanFull()
                                            ->html(),
                                    ])->columns(2),

                                Section::make('Data Anak')
                                    ->schema([
                                        TextEntry::make('jumlah_anak')
                                            ->label('Jumlah Anak'),
                                        TextEntry::make('pendidikan_anak')
                                            ->label('Pendidikan Anak'),
                                        TextEntry::make('kondisi_khusus_anak')
                                            ->label('Kondisi Khusus Anak')
                                            ->columnSpanFull()
                                            ->html(),
                                    ])->columns(2),
                            ]),

                        Tab::make('Kondisi Rumah')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Section::make('Kondisi Fisik Bangunan')
                                    ->schema([
                                        TextEntry::make('kondisi_atap')
                                            ->label('Kondisi Atap')
                                            ->badge()
                                            ->color(fn(string $state): string => match ($state) {
                                                'Baik' => 'success',
                                                'Rusak Ringan' => 'warning',
                                                'Rusak Berat' => 'danger',
                                                default => 'gray',
                                            }),
                                        TextEntry::make('kondisi_dinding')
                                            ->label('Kondisi Dinding')
                                            ->badge()
                                            ->color(fn(string $state): string => match ($state) {
                                                'Baik' => 'success',
                                                'Rusak Ringan' => 'warning',
                                                'Rusak Berat' => 'danger',
                                                default => 'gray',
                                            }),
                                        TextEntry::make('kondisi_lantai')
                                            ->label('Kondisi Lantai')
                                            ->badge()
                                            ->color(fn(string $state): string => match ($state) {
                                                'Baik' => 'success',
                                                'Rusak Ringan' => 'warning',
                                                'Rusak Berat' => 'danger',
                                                default => 'gray',
                                            }),
                                        TextEntry::make('luas_bangunan')
                                            ->label('Luas Bangunan')
                                            ->suffix(' m²'),
                                    ])->columns(2),

                                Section::make('Fasilitas & Utilitas')
                                    ->schema([
                                        TextEntry::make('ventilasi_pencahayaan')
                                            ->label('Ventilasi & Pencahayaan'),
                                        TextEntry::make('kamar_mandi_sanitasi')
                                            ->label('Kamar Mandi & Sanitasi'),
                                        TextEntry::make('daya_listrik')
                                            ->label('Daya Listrik'),
                                        TextEntry::make('sumber_air')
                                            ->label('Sumber Air'),
                                    ])->columns(2),

                                Section::make('Lingkungan & Legalitas')
                                    ->schema([
                                        TextEntry::make('rawan_banjir_longsor')
                                            ->label('Rawan Banjir/Longsor?')
                                            ->badge()
                                            ->color(fn(string $state): string => $state === 'Ya' ? 'danger' : 'success'),
                                        TextEntry::make('sedang_sengketa')
                                            ->label('Sedang Sengketa?')
                                            ->badge()
                                            ->color(fn(string $state): string => $state === 'Ya' ? 'danger' : 'success'),
                                    ])->columns(2),

                                Section::make('Catatan Tambahan')
                                    ->schema([
                                        TextEntry::make('catatan_khusus')
                                            ->label('Catatan Khusus')
                                            ->columnSpanFull()
                                            ->html(),
                                    ]),
                            ]),

                        Tab::make('Dokumentasi')
                            ->icon('heroicon-o-camera')
                            ->schema([
                                Section::make('Lokasi')
                                    ->schema([
                                        TextEntry::make('link_google_maps')
                                            ->label('Link Google Maps')
                                            ->url(fn($state) => $state, true)
                                            ->openUrlInNewTab()
                                            ->columnSpanFull(),
                                    ]),

                                Section::make('Dokumen Wajib')
                                    ->description('Dokumen yang sudah diupload')
                                    ->schema([
                                        ImageEntry::make('foto_ktp')
                                            ->label('Foto KTP')
                                            ->size(150),
                                        ImageEntry::make('foto_kk')
                                            ->label('Foto KK')
                                            ->size(150),
                                        ImageEntry::make('foto_tampak_depan')
                                            ->label('Foto Tampak Depan')
                                            ->size(150),
                                        ImageEntry::make('foto_dalam_rumah')
                                            ->label('Foto Dalam Rumah')
                                            ->size(150),
                                        ImageEntry::make('foto_petugas_survey')
                                            ->label('Foto Petugas Survey')
                                            ->size(150),
                                    ])->columns(2),

                                Section::make('Dokumen Tambahan')
                                    ->description('Dokumen pendukung (opsional)')
                                    ->schema([
                                        ImageEntry::make('foto_tampak_samping')
                                            ->label('Foto Tampak Samping')
                                            ->size(150),
                                        ImageEntry::make('foto_toilet')
                                            ->label('Foto Toilet')
                                            ->size(150),
                                        ImageEntry::make('foto_dapur')
                                            ->label('Foto Dapur')
                                            ->size(150),
                                    ])->columns(2),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
