@php
    use Carbon\Carbon;
@endphp

@if (!$controlPoint->evidences || $controlPoint->evidences->isEmpty())
    <div
        class="flex items-center justify-center py-6 px-4 bg-gray-50 dark:bg-gray-800/50 rounded border border-dashed border-gray-300 dark:border-gray-700">
        <svg class="w-8 h-8 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span class="text-sm text-gray-500">No evidence submitted</span>
    </div>
@else
    <div class="overflow-x-auto rounded border border-gray-200 dark:border-gray-700">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                <tr>
                    <th class="px-4 py-2 text-xs font-bold uppercase w-1/6">Period</th>
                    <th class="px-4 py-2 text-xs font-bold uppercase w-2/6">Notes</th>
                    <th class="px-4 py-2 text-xs font-bold uppercase w-2/6">Attachments</th>
                    <th class="px-4 py-2 text-xs font-bold uppercase text-right w-1/6">Date</th>
                    @if ($canDelete)
                        <th class="px-4 py-2 text-xs font-bold uppercase text-right w-1/6">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($controlPoint->evidences->sortByDesc('month') as $evidence)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        {{-- Period --}}
                        <td class="px-4 py-2 align-middle">
                            <span
                                class="inline-flex items-center gap-1 text-xs font-semibold text-gray-900 dark:text-gray-100">
                                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ Carbon::parse($evidence->month)->format('M Y') }}
                            </span>
                        </td>

                        {{-- Notes --}}
                        <td class="px-4 py-2 align-middle">
                            <span class="text-xs text-gray-700 dark:text-gray-300" title="{{ $evidence->note }}">
                                {!! nl2br($evidence->note) !!}
                            </span>
                        </td>

                        {{-- Attachments --}}
                        <td class="px-4 py-2 align-middle">
                            @php
                                $attachments = is_string($evidence->attachments)
                                    ? json_decode($evidence->attachments, true)
                                    : $evidence->attachments;
                            @endphp
                            @if ($attachments && is_array($attachments) && count($attachments) > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach ($attachments as $file)
                                        @php $fileName = basename($file['filename']); @endphp
                                        <a href="{{ asset('storage/' . $file['path']) }}" target="_blank"
                                            title="{{ $fileName }}"
                                            class="inline-flex items-center gap-0.5 px-1.5 py-0.5 rounded text-xs font-medium bg-teal-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 hover:shadow transition-shadow">
                                            <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            <span
                                                class="max-w-[80px] truncate text-[10px]">{{ \Illuminate\Support\Str::limit($fileName, 15) }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-xs text-gray-400">-</span>
                            @endif
                        </td>

                        {{-- Date --}}
                        <td class="px-4 py-2 align-middle text-right">
                            <span class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $evidence->created_at->format('d/m/y') }}
                            </span>
                        </td>
                        @if ($canDelete)
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <button type="button"
                                        wire:click="mountAction('deleteEvidence', { evidenceId: '{{ $evidence['id'] }}' })"
                                        class="text-red-700">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-2 flex items-center justify-between text-xs text-gray-600 dark:text-gray-400">
        @php
            $totalRecords = $controlPoint->evidences->count();
            $totalAttachments = $controlPoint->evidences->sum(function ($e) {
                $att = is_string($e->attachments) ? json_decode($e->attachments, true) : $e->attachments;
                return is_array($att) ? count($att) : 0;
            });
        @endphp
        <span>
            {{ $totalRecords }} record{{ $totalRecords > 1 ? 's' : '' }} •
            {{ $totalAttachments }} file{{ $totalAttachments > 1 ? 's' : '' }}
        </span>
        <span>
            Updated
            {{ $controlPoint->evidences->sortByDesc('created_at')->first()->created_at->diffForHumans() }}
        </span>
    </div>
@endif
