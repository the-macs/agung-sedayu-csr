<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-gray-800">
                Recent Activity
            </h3>

            <span class="text-xs text-gray-500 italic">
                Showing latest {{ $records }} entries
            </span>
        </div>

        @if ($this->recentActivities->isEmpty())
            <div class="text-sm text-gray-500 text-center py-4">
                No recent activity.
            </div>
        @else
            <ul class="relative space-y-4 pl-2">
                @foreach ($this->recentActivities as $activity)
                    <li class="relative flex items-start gap-3 ">
                        {{-- Connector line (only if not the last item) --}}
                        @if (!$loop->first)
                            <span class="absolute left-[0.29rem] -top-2 h-1/2 w-px bg-primary-500" aria-hidden="true">
                            </span>
                        @endif

                        @if (!$loop->last)
                            <span class="absolute left-[0.29rem] top-3 h-full w-px bg-primary-500" aria-hidden="true">
                            </span>
                        @endif

                        {{-- Dot --}}
                        <span class="relative z-10 w-2.5 h-2.5 mt-2 rounded-full bg-primary-500 shrink-0"
                            aria-hidden="true">
                        </span>

                        <div class="flex-1 min-w-0">
                            {{-- Description --}}
                            <p class="text-sm font-medium text-gray-800 truncate">
                                {{ $activity->description ?? ($activity->log_name ?? 'Activity') }}
                            </p>

                            {{-- Meta line --}}
                            <p class="mt-0.5 text-xs text-gray-400">
                                @if (isset($activity->causer) && ($activity->causer->name ?? false))
                                    <span class="font-medium text-gray-500 italic">
                                        {{ Str::title($activity->causer->name) }}
                                    </span>
                                    ·
                                @endif
                                {{ optional($activity->created_at)->diffForHumans() ?? '' }}
                            </p>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
