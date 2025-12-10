<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends Model
{
    use HasUlids, LogsActivity;

    protected $keyType = 'string';

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Project Status Constants
    public const STATUS_DRAFT = 'draft';
    public const STATUS_ONGOING = 'ongoing';
    public const STATUS_FINISH = 'finish';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_DRAFT => 'Draft',
        self::STATUS_ONGOING => 'Ongoing',
        self::STATUS_FINISH => 'finish',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    // Kecamatan options
    public const KECAMATAN = [
        'Kosambi' => 'Kosambi',
        'Teluknaga' => 'Teluknaga',
        'Pakuhaji' => 'Pakuhaji',
        'Sepatan' => 'Sepatan',
        'Sepatan Timur' => 'Sepatan Timur',
        'Sukadiri' => 'Sukadiri',
        'Mauk' => 'Mauk',
        'Kemiri' => 'Kemiri',
        'Kronjo' => 'Kronjo',
    ];

    // Status Kepemilikan options
    public const STATUS_KEPEMILIKAN = [
        'Milik Sendiri' => 'Milik Sendiri',
        'Warisan' => 'Warisan',
    ];

    // Status Tanah options
    public const STATUS_TANAH = [
        'SHM (Sertifikat Hak Milik)' => 'SHM (Sertifikat Hak Milik)',
        'Girik / Letter C' => 'Girik / Letter C',
        'SKT (Surat Keterangan Tidak Sengketa)' => 'SKT (Surat Keterangan Tidak Sengketa)',
        'SPPT (Surat Pemberitahuan Pajak Terutang)' => 'SPPT (Surat Pemberitahuan Pajak Terutang)',
        'AJB (Akta Jual Beli)' => 'AJB (Akta Jual Beli)',
    ];

    // Boolean options
    public const YA_TIDAK = [
        'Ya' => 'Ya',
        'Tidak' => 'Tidak',
    ];

    // Anggota Rentan options
    public const ANGGOTA_RENTAN = [
        'Lansia' => 'Lansia',
        'Disabilitas' => 'Disabilitas',
        'Yatim/Piatu' => 'Yatim/Piatu',
        'Tidak Ada' => 'Tidak Ada',
    ];

    // Status options
    public const STATUS_HIDUP = [
        'Hidup' => 'Hidup',
        'Meninggal' => 'Meninggal',
    ];

    // Jenis Bantuan options
    public const JENIS_BANTUAN = [
        'PKH' => 'PKH',
        'BPNT' => 'BPNT',
        'BLT Desa' => 'BLT Desa',
    ];

    // Kondisi options
    public const KONDISI_ATAP = [
        'Baik' => 'Baik',
        'Bocor Sebagian' => 'Bocor Sebagian',
        'Rusak Berat' => 'Rusak Berat',
    ];

    public const KONDISI_DINDING = [
        'Tembok Utuh' => 'Tembok Utuh',
        'Tembok Retak' => 'Tembok Retak',
        'Bambu / Kayu Lapuk' => 'Bambu / Kayu Lapuk',
    ];

    public const KONDISI_LANTAI = [
        'Keramik' => 'Keramik',
        'Semen' => 'Semen',
        'Tanah' => 'Tanah',
    ];

    public const VENTILASI_PENCAHAYAAN = [
        'Cukup' => 'Cukup',
        'Kurang' => 'Kurang',
        'Baik' => 'Baik',
    ];

    public const KAMAR_MANDI_SANITASI = [
        'Layak' => 'Layak',
        'Tidak Layak' => 'Tidak Layak',
    ];

    public const DAYA_LISTRIK = [
        '450' => '450 Watt',
        '900' => '900 Watt',
        '1300' => '1300 Watt',
        'Tidak Ada' => 'Tidak Ada',
    ];

    public const SUMBER_AIR = [
        'Sumur Bor' => 'Sumur Bor',
        'Sumur Gali' => 'Sumur Gali',
        'PDAM' => 'PDAM',
    ];

    public function canBeStarted(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function canBeFinish(): bool
    {
        return $this->status === self::STATUS_ONGOING;
    }

    public function startProject(): void
    {
        if ($this->canBeStarted()) {
            $this->update(['status' => self::STATUS_ONGOING]);
        }
    }

    public function endProject(): void
    {
        $this->update(['status' => self::STATUS_FINISH]);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(ProjectMaterial::class);
    }

    public function generateMaterialsFromDefaults(): void
    {
        $defaultMaterials = ItemMaterial::all();

        foreach ($defaultMaterials as $material) {
            $projectMaterial = $this->projectMaterials()->create([
                'project_id' => $this->id,
                'name' => $material->name,
                'uom' => $material->uom->name,
                'quantity' => $material->quantity,
            ]);

            $projectMaterial->transactions()->create([
                'project_material_id' => $projectMaterial->id,
                'quantity' => $material->quantity,
                'type' => 'in',
                'status' => 'approved',
                'request_by' => Auth::id(),
                'approved_by' => Auth::id(),
                'note' => 'Generated from default materials',
            ]);
        }
    }

    public function projectMaterials(): HasMany
    {
        return $this->hasMany(ProjectMaterial::class);
    }

    public function weeklyReports(): HasMany
    {
        return $this->hasMany(ProjectWeeklyReport::class);
    }

    // Get current week progress
    public function getCurrentWeekAttribute()
    {
        $lastCompleted = $this->weeklyReports()
            ->where('is_completed', true)
            ->orderBy('week_number', 'desc')
            ->first();

        return $lastCompleted ? $lastCompleted->week_number + 1 : 1;
    }

    // Check if specific week can be started
    public function canStartWeek(int $weekNumber): bool
    {
        if ($weekNumber === 1) return true;

        $previousWeek = $this->weeklyReports()
            ->where('week_number', $weekNumber - 1)
            ->where('is_completed', true)
            ->exists();

        return $previousWeek;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return (new LogOptions())
            ->logAll();
    }
}
