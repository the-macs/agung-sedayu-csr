@php
    // Check Laravel's maintenance mode status
    $isMaintenance = setting('maintenance_mode');

    // Check Laravel's debug status (usually set in .env)
    $isDebug = config('app.debug');

    // You can customize the styling (using Tailwind CSS classes)
@endphp

<div class="flex flex-col items-center text-sm font-semibold">

    {{-- Maintenance Mode Status --}}
    @if ($isMaintenance)
        <span class="px-2 w-full rounded-t-lg py-1 bg-danger-600 text-white shadow-sm text-center">
            <x-heroicon-s-exclamation-triangle class="w-4 h-4 inline-block -mt-0.5"/>
            MAINTENANCE
        </span>
    @endif

    {{-- Debug Status (Only show if enabled) --}}
    @if ($isDebug)
        <span
            class="px-2 w-full @if (!$isMaintenance) rounded-t-lg @endif  py-1 bg-info-500 text-info-900 shadow-sm text-center">
            <x-heroicon-s-bug-ant class="w-4 h-4 inline-block -mt-0.5"/>
            DEBUG
        </span>
    @endif
</div>
