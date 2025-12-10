<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectWeeklyReport extends Model
{
    use HasUlids;

    protected $guarded = [];

    protected $casts = [
        'checklists' => 'array',
        'attachments' => 'array',
        'completed_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // Get checklist items for each week
    public static function getWeekChecklists($weekNumber): array
    {
        $checklists = [
            1 => [
                'Persiapan alat & mobilisasi material',
                'Pembongkaran rumah lama',
                'Pembuatan pondasi & sloof',
            ],
            2 => [
                'Pemasangan kolom & balok',
                'Pemasangan dinding',
                'Pengecoran ring balok atas',
            ],
            3 => [
                'Pemasangan atap baja ringan',
                'Pekerjaan plester',
                'Pemasangan Plafon',
                'Pemasangan Keramik Lantai',
            ],
            4 => [
                'Pengecatan dinding, pintu dan jendela',
                'Instalasi listrik',
                'Instalasi air',
                'Serah terima hasil pekerjaan',
            ],
        ];

        return $checklists[$weekNumber] ?? [];
    }

    // Get week details
    public static function getWeekDetails(int $weekNumber): array
    {
        $weeks = [
            1 => [
                'title' => 'Week 1 - Persiapan & Pembongkaran',
                'focus' => 'Pondasi dan Sloof',
                'icon' => 'heroicon-o-wrench-screwdriver',
            ],
            2 => [
                'title' => 'Week 2 - Struktur Utama',
                'focus' => 'Dinding, Kolom, Ring Balok',
                'icon' => 'heroicon-o-building-storefront',
            ],
            3 => [
                'title' => 'Week 3 - Pekerjaan Atap & Lantai',
                'focus' => 'Atap, lantai, plester, instalasi',
                'icon' => 'heroicon-o-home',
            ],
            4 => [
                'title' => 'Week 4 - Finishing & Serah Terima',
                'focus' => 'Cat, pembersihan, serah terima',
                'icon' => 'heroicon-o-clipboard-document-check',
            ],
        ];

        return $weeks[$weekNumber] ?? [];
    }

    // Check if previous week is completed
    public function canStartWeek(): bool
    {
        if ($this->week_number === 1) {
            return true; // Week 1 can always start
        }

        $previousWeek = ProjectWeeklyReport::where('project_id', $this->project_id)
            ->where('week_number', $this->week_number - 1)
            ->where('is_completed', true)
            ->exists();

        return $previousWeek;
    }

    // Get next available week number for this project
    public static function getNextWeekNumber($projectId): int
    {
        $lastReport = ProjectWeeklyReport::where('project_id', $projectId)
            ->where('is_completed', true)
            ->orderBy('week_number', 'desc')
            ->first();

        return $lastReport ? $lastReport->week_number + 1 : 1;
    }
}
