<div class="flex items-center justify-between p-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-300 dark:bg-gray-900 dark:ring-white/10">
    <a href="{{ url('customer/wallet-transactions') }}" class="flex-1">
        <div class="flex flex-col">
            <span class="fi-wi-stats-overview-stat-label text-sm font-medium text-gray-600 dark:text-gray-400">
                Wallet Balance
            </span>
            <div class="fi-wi-stats-overview-stat-value text-3xl font-semibold tracking-tight text-gray-900 dark:text-white">
                $ {{ number_format($walletBalance, 2) }}
            </div>
        </div>
    </a>

    <!-- Conditional Withdraw Button -->
    
        <button 
            type="button" 
            class="ml-4 px-4 py-2 bg-white text-black border border-black rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:text-white dark:border-white dark:hover:bg-gray-700"

@if($walletBalance > 0)
            onclick="window.location.href='{{ url('customer/withdraw-requests/create') }}'"
@endif
            >
            Withdraw
        </button>

</div>
