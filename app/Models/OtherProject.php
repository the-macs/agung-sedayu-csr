<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OtherProject extends Model
{
    use HasUlids;

    protected $fillable = [
        'code',
        'project_name',
        'nama_lembaga',
        'penanggung_jawab',
        'no_whatsapp',
        'alamat_lengkap',
        'link_google_maps',
        'photos',
        'status'
    ];

    protected $casts = [
        'photos' => 'array',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->code)) {
                $project->code = static::generateProjectCode();
            }
        });
    }

    public static function generateProjectCode(): string
    {
        // Get the last project code
        $lastProject = static::orderBy('created_at', 'desc')->first();

        if (!$lastProject || !preg_match('/^OTHPRJ-(\d{3})-(\d{2})$/', $lastProject->code, $matches)) {
            // Start from OTHPRJ-001-01 if no projects exist
            return 'OTHPRJ-001-01';
        }

        $xxx = (int) $matches[1]; // Extract XXX part
        $yy = (int) $matches[2];  // Extract YY part

        // Increment YY, if it reaches 99, reset to 01 and increment XXX
        $yy++;
        if ($yy > 99) {
            $yy = 1;
            $xxx++;
        }

        // Format with leading zeros
        return sprintf('OTHPRJ-%03d-%02d', $xxx, $yy);
    }

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
        return $this->hasMany(ProjectMaterial::class, 'reference_id', 'id');
    }

    public function otherWeeklyReports(): HasMany
    {
        return $this->hasMany(OtherProjectWeeklyReport::class);
    }
}
