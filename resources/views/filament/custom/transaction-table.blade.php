<div class="space-y-6">
    <!-- Material Summary Card -->
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-xl p-6 border border-gray-200 dark:border-gray-700 transition">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">Material Overview</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 transition">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Material Name</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-1">{{ $material->name }}</p>
            </div>

            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 transition">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Current Stock</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-1">
                    {{ $material->quantity }} {{ $material->uom }}
                </p>
            </div>

            <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 transition">
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Project</p>
                <p class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-1">
                    {{ $material->project->nama_lengkap }}
                </p>
            </div>
        </div>
    </div>


    <!-- Transactions Table -->
    <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl border border-gray-200 dark:border-gray-700 transition overflow-hidden">
        <div class="px-6 py-4 border-b bg-gray-50 dark:bg-gray-800 dark:border-gray-700 transition flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100">Material Transactions</h3>
            <div class="text-sm text-gray-500 dark:text-gray-400">
                Total: {{ $transactions->total() }} transactions
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-800 transition">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Note</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Requested By</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700 transition">
                    @forelse($transactions as $transaction)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                                {{ $transaction->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                {{ $transaction->quantity }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $transaction->type === 'in'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                                        : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300'
                                    }}">
                                    {{ $transaction->type === 'in' ? 'Stock In' : 'Stock Out' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $transaction->status === 'approved'
                                        ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300'
                                        : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300'
                                    }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                {{ $transaction->note ? \Illuminate\Support\Str::limit($transaction->note, 50) : '-' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                {{ $transaction->requester->name ?? 'N/A' }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $transaction->created_at->format('M j, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                No transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700 dark:text-gray-300">
                    Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }} results
                </div>
                <div class="flex space-x-2">
                    <!-- Previous Page Link -->
                    @if($transactions->onFirstPage())
                        <span class="px-3 py-1 text-sm text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <a href="?page={{ $transactions->currentPage() - 1 }}" class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500 transition">
                            Previous
                        </a>
                    @endif

                    <!-- Page Numbers -->
                    @foreach(range(1, $transactions->lastPage()) as $page)
                        @if($page == $transactions->currentPage())
                            <span class="px-3 py-1 text-sm text-white bg-blue-600 dark:bg-blue-500 rounded-md">
                                {{ $page }}
                            </span>
                        @else
                            <a href="?page={{ $page }}" class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500 transition">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if($transactions->hasMorePages())
                        <a href="?page={{ $transactions->currentPage() + 1 }}" class="px-3 py-1 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md hover:bg-gray-50 dark:hover:bg-gray-500 transition">
                            Next
                        </a>
                    @else
                        <span class="px-3 py-1 text-sm text-gray-400 dark:text-gray-600 bg-gray-100 dark:bg-gray-700 rounded-md cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
