<?php

namespace App\Providers\Filament;

use AchyutN\FilamentLogViewer\FilamentLogViewer;
use App\Filament\Pages\Auth\MyLogin;
use App\Http\Middleware\CheckMaintenanceMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(MyLogin::class)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                \App\Filament\Widgets\RecentActivityWidget::class,
            ])
            ->renderHook(
                PanelsRenderHook::USER_MENU_PROFILE_BEFORE,
                fn() => view('filament.admin.components.status-indicator'),
            )
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ]) // ADD THIS CRITICAL SECTION:
            ->renderHook(
                'panels::body.start',
                fn(): string => Blade::render(<<<'HTML'
                <script>
                    // FIXED: Proper Livewire subdirectory fix
                    document.addEventListener('livewire:init', function() {
                        console.log('[Livewire Fix] Initializing for subdirectory');
                        
                        const baseUrl = '<?php echo config("app.url"); ?>';
                        console.log('[Livewire Fix] Base URL:', baseUrl);
                        
                        // SAFE VERSION: Check for uri before using it
                        Livewire.hook('request', ({ options, succeed, fail }) => {
                            // Check if options.url exists and fix it
                            if (options && options.url) {
                                console.log('[Livewire Fix] Request URL:', options.url);
                                
                                // Fix Livewire update requests
                                if (typeof options.url === 'string' && 
                                    options.url.includes('/livewire/update') &&
                                    !options.url.startsWith('http')) {
                                    
                                    const fixedUrl = baseUrl + (options.url.startsWith('/') ? '' : '/') + options.url;
                                    console.log('[Livewire Fix] Fixed URL:', fixedUrl);
                                    options.url = fixedUrl;
                                }
                            }
                            
                            // Continue with the request
                            succeed(({ status, response }) => {
                                return { status, response };
                            });
                        });
                        
                        // Alternative: Direct fetch interception (safer)
                        const originalFetch = window.fetch;
                        window.fetch = function(resource, init) {
                            if (typeof resource === 'string') {
                                // Fix Livewire update requests
                                if (resource.includes('/livewire/update') && 
                                    !resource.startsWith('http') &&
                                    !resource.startsWith(baseUrl)) {
                                    
                                    const fixedResource = baseUrl + (resource.startsWith('/') ? '' : '/') + resource;
                                    console.log('[Livewire Fix] Fetch intercepted:', resource, '→', fixedResource);
                                    resource = fixedResource;
                                }
                            }
                            return originalFetch.call(this, resource, init);
                        };
                        
                        console.log('[Livewire Fix] Applied successfully');
                    });
                    
                    // Fallback for early requests
                    (function() {
                        const baseUrl = '<?php echo config("app.url"); ?>';
                        const originalOpen = XMLHttpRequest.prototype.open;
                        
                        XMLHttpRequest.prototype.open = function(method, url) {
                            if (url && typeof url === 'string' && 
                                url.includes('/livewire/update') && 
                                !url.startsWith('http')) {
                                
                                const fixedUrl = baseUrl + (url.startsWith('/') ? '' : '/') + url;
                                console.log('[Livewire Fix] XHR fixed:', url, '→', fixedUrl);
                                return originalOpen.call(this, method, fixedUrl);
                            }
                            return originalOpen.call(this, method, url);
                        };
                    })();
                </script>
            HTML)
            )
            ->authMiddleware([
                Authenticate::class,
                CheckMaintenanceMode::class,
            ])
            ->plugins([
                FilamentLogViewer::make()
                    ->authorize(fn() => Auth::user()->can('view.any.log.system'))
                    ->navigationGroup('Logs')
                    ->navigationIcon('heroicon-o-bug-ant')
                    ->navigationLabel('System Logs')
                    ->navigationSort(99)
                    ->navigationUrl('/logs')
                    ->pollingTime(null), // Set to null to disable polling
            ])
            ->topNavigation(setting('top_navigation', false))
            ->brandLogo(fn() => view('filament.admin.components.header-logo'))
            ->font('Outfit', url: asset('fonts/filament/filament/Outfit/Outfit-VariableFont_wght.ttf'))
            // Based on Settings
            ->favicon(setting('site_favicon', null))
            ->defaultThemeMode(app_theme_mode())
            ->darkMode(setting('allow_theme_switching', false))
            ->sidebarWidth(app_sidebar_width())
            ->maxContentWidth(app_container_width())
            ->breadcrumbs(setting('show_breadcrumbs', true));
    }
}
