@php
    $bank = \App\Models\BankAccount::find($getRecord()->bank_id);
@endphp

@if ($bank)
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Bank Details</h3>
        <table class="table-auto w-full border-collapse text-gray-900 dark:text-white">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b border-gray-300 dark:border-gray-600">Field</th>
                    <th class="px-4 py-2 text-left border-b border-gray-300 dark:border-gray-600">Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="px-4 py-2 font-medium">Bank Name</td>
                    <td class="px-4 py-2">{{ $bank->bank_name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Account Number</td>
                    <td class="px-4 py-2">{{ $bank->account_number }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">IFSC Code</td>
                    <td class="px-4 py-2">{{ $bank->ifsc_code }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">UPI ID</td>
                    <td class="px-4 py-2">{{ $bank->upi_id }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Branch Name</td>
                    <td class="px-4 py-2">{{ $bank->branch_name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Account Type</td>
                    <td class="px-4 py-2">{{ $bank->account_type }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Account Holder Name</td>
                    <td class="px-4 py-2">{{ $bank->customer_name }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Bank-Registered Mobile Number</td>
                    <td class="px-4 py-2">{{ $bank->mobile_number }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Bank Verification Status</td>
                    <td class="px-4 py-2">{{ $bank->status == 1 ? 'Bank Verified' : 'Bank Not Verified' }}</td>
                </tr>
                <tr>
                    <td class="px-4 py-2 font-medium">Customer Message</td>
                    <td class="px-4 py-2">{{ $getRecord()->customer_message ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@else
    <div class="bg-gray-100 dark:bg-gray-700 p-6 rounded-lg">
        <p class="text-gray-700 dark:text-gray-300">No bank selected</p>
    </div>
@endif
