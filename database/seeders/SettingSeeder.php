<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // You can add code here to seed settings data into the database
        Setting::insert([
            ['key' => 'site_name', 'value' => 'Boilerplate Filament 4'],
            ['key' => 'site_description', 'value' => ''],
            ['key' => 'site_logo', 'value' => 'https://s3.ap-southeast-1.wasabisys.com/gdps-common/icon/gdps-icon.webp'],
            ['key' => 'site_favicon', 'value' => 'https://s3.ap-southeast-1.wasabisys.com/gdps-common/icon/gdps-icon.ico'],
            ['key' => 'timezone', 'value' => 'Asia/Jakarta'],
            ['key' => 'date_format', 'value' => 'Y-m-d'],
            ['key' => 'time_format', 'value' => 'H:i:s'],
            ['key' => 'session_lifetime', 'value' => 1440],
            ['key' => 'login_attempts', 'value' => 5],
            ['key' => 'theme', 'value' => 'system'],
            ['key' => 'maintenance_mode', 'value' => 0],
            ['key' => 'debug_mode', 'value' => 0],
            ['key' => 'allow_theme_switching', 'value' => 1],
            ['key' => 'top_navigation', 'value' => 1],
            ['key' => 'show_breadcrumbs', 'value' => 1],
            ['key' => 'show_logo', 'value' => 1],
            ['key' => 'show_app_name', 'value' => 1],
        ]);
    }
}
