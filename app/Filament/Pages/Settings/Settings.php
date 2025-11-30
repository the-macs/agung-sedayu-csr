<?php

namespace App\Filament\Pages\Settings;

use UnitEnum;
use BackedEnum;
use App\Services\SettingService;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;

class Settings extends Page implements HasSchemas
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings.settings';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 99;

    protected static ?string $title = 'Settings';

    protected static ?string $navigationLabel = 'Settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(app(SettingService::class)->all());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Settings')
                    ->tabs([
                        /** -------------------------
                         * General Tab
                         * ------------------------ */
                        Tab::make('General')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Site Information')
                                    ->schema([
                                        TextInput::make('site_name')
                                            ->label('Site Name')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('site_description')
                                            ->label('Site Description')
                                            ->rows(3)
                                            ->maxLength(500),
                                        TextInput::make('site_logo')
                                            ->label('Site Logo (URL)')
                                            ->url(),
                                        TextInput::make('site_favicon')
                                            ->label('Favicon (URL)')
                                            ->url(),
                                    ])
                                    ->columns(),

                                Section::make('Regional Settings')
                                    ->schema([
                                        Select::make('timezone')
                                            ->label('Timezone')
                                            ->options(array_combine(timezone_identifiers_list(), timezone_identifiers_list()))
                                            ->searchable()
                                            ->required(),
                                        TextInput::make('date_format')
                                            ->label('Date Format')
                                            ->helperText('e.g., Y-m-d, d/m/Y, m/d/Y')
                                            ->required(),
                                        TextInput::make('time_format')
                                            ->label('Time Format')
                                            ->helperText('e.g., H:i:s, h:i A')
                                            ->required(),
                                    ])
                                    ->columns(3),
                            ])
                            ->visible(fn() => auth()->user()->can('update', [\App\Models\Setting::class, 'general'])),

                        /** -------------------------
                         * System Tab
                         * ------------------------ */
                        Tab::make('System')
                            ->icon('heroicon-o-server')
                            ->schema([
                                Section::make('System Configuration')
                                    ->schema([
                                        Toggle::make('maintenance_mode')
                                            ->label('Maintenance Mode')
                                            ->helperText('Enable to put the site in maintenance mode'),
                                        Toggle::make('debug_mode')
                                            ->label('Debug Mode')
                                            ->helperText('Warning: Only enable in development'),
                                    ])
                                    ->columns(),
                            ])
                            ->visible(fn() => auth()->user()->can('update', [\App\Models\Setting::class, 'system'])),

                        /** -------------------------
                         * Security Tab
                         * ------------------------ */
                        Tab::make('Security')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Section::make('Security Settings')
                                    ->schema([
                                        TextInput::make('session_lifetime')
                                            ->label('Session Lifetime (minutes)')
                                            ->numeric()
                                            ->default(120)
                                            ->required(),
                                        TextInput::make('login_attempts')
                                            ->label('Max Login Attempts')
                                            ->numeric()
                                            ->minValue(3)
                                            ->maxValue(10)
                                            ->default(5)
                                            ->required(),
                                    ])
                                    ->columns(),
                            ])
                            ->visible(fn() => auth()->user()->can('update', [\App\Models\Setting::class, 'security'])),

                        /** -------------------------
                         * Appearance Tab
                         * ------------------------ */
                        Tab::make('Appearance')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Section::make('Theme Settings')
                                    ->schema([
                                        Select::make('theme')
                                            ->label('Default Theme')
                                            ->options([
                                                'light' => 'Light',
                                                'dark' => 'Dark',
                                                'system' => 'Auto (System)',
                                            ])
                                            ->default('light')
                                            ->required()
                                            ->helperText('Choose the default theme for your application'),

                                        Toggle::make('allow_theme_switching')
                                            ->label('Allow Users to Switch Theme')
                                            ->helperText('Let users change theme from their profile')
                                            ->default(true),
                                    ])
                                    ->columns(),

                                Section::make('Color Scheme')
                                    ->schema([
                                        ColorPicker::make('primary_color')
                                            ->label('Primary Color')
                                            ->default('#3b82f6'),
                                        ColorPicker::make('secondary_color')
                                            ->label('Secondary Color')
                                            ->default('#8b5cf6'),
                                        ColorPicker::make('success_color')
                                            ->label('Success Color')
                                            ->default('#10b981'),
                                        ColorPicker::make('warning_color')
                                            ->label('Warning Color')
                                            ->default('#f59e0b'),
                                        ColorPicker::make('danger_color')
                                            ->label('Danger Color')
                                            ->default('#ef4444'),
                                        ColorPicker::make('info_color')
                                            ->label('Info Color')
                                            ->default('#0ea5e9'),
                                    ])
                                    ->columns(3),

                                Section::make('Layout Settings')
                                    ->schema([
                                        Toggle::make('top_navigation')
                                            ->label('Top Navigation Layout')
                                            ->live()
                                            ->default(false),
                                        Select::make('sidebar_width')
                                            ->label('Sidebar Width')
                                            ->options([
                                                'compact' => 'Compact',
                                                'normal' => 'Normal',
                                                'wide' => 'Wide',
                                            ])
                                            ->visible(fn(callable $get) => !$get('top_navigation'))
                                            ->default('normal'),
                                        Toggle::make('sidebar_collapsible')
                                            ->label('Collapsible Sidebar')
                                            ->visible(fn(callable $get) => !$get('top_navigation'))
                                            ->default(true),
                                        Select::make('container_width')
                                            ->label('Container Width')
                                            ->options([
                                                'default' => 'Default',
                                                'md' => 'Medium',
                                                'lg' => 'Large',
                                                '2xl' => '2X Large',
                                                'full' => 'Full Width',
                                            ])
                                            ->default('7xl'),
                                        Toggle::make('show_breadcrumbs')
                                            ->label('Show Breadcrumbs')
                                            ->default(true),
                                    ])
                                    ->columns(3),

                                Section::make('Branding')
                                    ->schema([
                                        Toggle::make('show_logo')
                                            ->label('Show Logo in Sidebar')
                                            ->default(true),
                                        Toggle::make('show_app_name')
                                            ->label('Show App Name')
                                            ->default(true),
                                        TextInput::make('custom_css')
                                            ->label('Custom CSS Class')
                                            ->placeholder('bg-gradient-to-r from-blue-500 to-purple-600'),
                                    ])
                                    ->columns(3),

                                Section::make('Advanced')
                                    ->collapsed()
                                    ->schema([
                                        Textarea::make('custom_css_code')
                                            ->label('Custom CSS Code')
                                            ->rows(6),
                                        Textarea::make('custom_js')
                                            ->label('Custom JavaScript')
                                            ->rows(6),
                                    ]),
                            ])
                            ->visible(fn() => auth()->user()->can('update', [\App\Models\Setting::class, 'appearance'])),

                        /** -------------------------
                         * Social Media Tab
                         * ------------------------ */
                        Tab::make('Social Media')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Social Media Links')
                                    ->schema([
                                        TextInput::make('facebook_url')
                                            ->label('Facebook URL')
                                            ->url()
                                            ->prefix('https://'),
                                        TextInput::make('twitter_url')
                                            ->label('Twitter/X URL')
                                            ->url()
                                            ->prefix('https://'),
                                        TextInput::make('instagram_url')
                                            ->label('Instagram URL')
                                            ->url()
                                            ->prefix('https://'),
                                        TextInput::make('linkedin_url')
                                            ->label('LinkedIn URL')
                                            ->url()
                                            ->prefix('https://'),
                                    ])
                                    ->columns(),
                            ])
                            ->visible(fn() => auth()->user()->can('update', [\App\Models\Setting::class, 'social'])),

                        /** -------------------------
                         * SEO Tab
                         * ------------------------ */
                        Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('SEO Settings')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60),
                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->maxLength(160)
                                            ->rows(3),
                                        TagsInput::make('meta_keywords')
                                            ->label('Meta Keywords')
                                            ->placeholder('Enter keywords')
                                            ->separator(),
                                        TextInput::make('google_analytics_id')
                                            ->label('Google Analytics ID')
                                            ->placeholder('G-XXXTENTACION'),
                                    ]),
                            ])
                            ->visible(fn() => auth()->user()->can('update', [\App\Models\Setting::class, 'seo'])),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull()
                    ->contained(false),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            app(SettingService::class)->set($key, $value);
        }

        app(SettingService::class)->clearCache();

        // Apply maintenance mode immediately
        if (isset($state['maintenance_mode'])) {
            $this->applyMaintenanceMode((bool)$state['maintenance_mode']);
        }

        // Note: Debug mode will apply on next request
        if (isset($state['debug_mode']) && !app()->environment('production')) {
            Notification::make()
                ->title('Debug mode will apply on next request')
                ->info()
                ->send();
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }

    private function applyMaintenanceMode(bool $enabled): void
    {
        // Just store the setting - we'll handle it in middleware
        cache()->put('app.maintenance_mode', $enabled, now()->addYear());
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save')
                ->color('primary'),
        ];
    }

    public static function canAccess(): bool
    {
        return auth()->user()->can('viewAny', \App\Models\Setting::class);
    }
}
