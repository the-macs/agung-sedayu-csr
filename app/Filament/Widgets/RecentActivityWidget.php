<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Spatie\Activitylog\Models\Activity;

class RecentActivityWidget extends Widget
{
    protected string $view = 'filament.widgets.recent-activity-widget';

    // Controls how many records to show (you can override from the dashboard)
    public int $records = 6;

    public function getRecentActivitiesProperty()
    {
        return Activity::with('causer')
            ->latest()
            ->take($this->records)
            ->get();
    }
}
