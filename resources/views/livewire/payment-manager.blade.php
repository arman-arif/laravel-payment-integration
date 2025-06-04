<div x-data>
    <x-slot name="header">
        <x-breadcrumb page-name="Payments"/>
    </x-slot>
    <!-- Header Section -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Payment Management</h2>

        <button
            wire:click="showCreateForm"
            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Payment
        </button>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="relative">
            <span class="absolute top-1/2 left-4 -translate-y-1/2">
                <svg class="fill-gray-500 dark:fill-gray-400" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M3.04175 9.37363C3.04175 5.87693 5.87711 3.04199 9.37508 3.04199C12.8731 3.04199 15.7084 5.87693 15.7084 9.37363C15.7084 12.8703 12.8731 15.7053 9.37508 15.7053C5.87711 15.7053 3.04175 12.8703 3.04175 9.37363ZM9.37508 1.54199C5.04902 1.54199 1.54175 5.04817 1.54175 9.37363C1.54175 13.6991 5.04902 17.2053 9.37508 17.2053C11.2674 17.2053 13.003 16.5344 14.357 15.4176L17.177 18.238C17.4699 18.5309 17.9448 18.5309 18.2377 18.238C18.5306 17.9451 18.5306 17.4703 18.2377 17.1774L15.418 14.3573C16.5365 13.0033 17.2084 11.2669 17.2084 9.37363C17.2084 5.04817 13.7011 1.54199 9.37508 1.54199Z"
                          fill=""/>
                </svg>
            </span>
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search payments..."
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-4 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
            />
        </div>
    </div>

    <!-- Form Modal -->
    @if($showForm)
        <div class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4">
            <div
                class="w-full max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        {{ $editingPaymentId ? 'Edit Payment' : 'Create Payment' }}
                    </h3>
                    <button
                        wire:click="hideForm"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Name Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Name
                            </label>
                            <input
                                type="text"
                                wire:model="name"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('name') border-error-300 dark:border-error-700 @enderror"
                                placeholder="Enter name"
                            />
                            @error('name')
                            <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <input
                                type="email"
                                wire:model="email"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('email') border-error-300 dark:border-error-700 @enderror"
                                placeholder="Enter email"
                                @disabled($is_paid)
                            />
                            @error('email')
                            <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Amount
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                wire:model="amount"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('amount') border-error-300 dark:border-error-700 @enderror"
                                placeholder="0.00"
                                @disabled($is_paid)
                            />
                            @error('amount')
                            <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Currency
                            </label>
                            <select
                                wire:model="currency"
                                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 @error('currency') border-error-300 dark:border-error-700 @enderror"
                                @disabled($is_paid)
                            >
                                <option value="DKK">DKK</option>
                                <option value="EUR">EUR</option>
                                <option value="GBP">GBP</option>
                                <option value="USD">USD</option>
                            </select>
                            @error('currency')
                            <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <!-- Description Field -->
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Description
                        </label>
                        <textarea
                            wire:model="description"
                            rows="4"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('description') border-error-300 dark:border-error-700 @enderror"
                            placeholder="Enter description"
                        ></textarea>
                        @error('description')
                        <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3">
                        <button
                            type="button"
                            wire:click="hideForm"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-hidden focus:ring-3 focus:ring-gray-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            wire:target="save"
                            class="inline-flex items-center rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            <span wire:loading.remove wire:target="save">
                                {{ $editingPaymentId ? 'Update' : 'Create' }} Payment
                            </span>
                            <span wire:loading wire:target="save" class="flex items-center">
                                <x-loading-spinner size="sm" color="white" class="mr-2"/>
                                {{ $editingPaymentId ? 'Updating...' : 'Creating...' }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Payments Table -->
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
                Payments List
            </h3>
        </div>
        <div class="border-t border-gray-100 dark:border-gray-800">
            <div class="overflow-hidden rounded-xl">
                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <!-- Table Header -->
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-gray-800">
                                <th class="px-5 py-3 sm:px-6">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">S/N</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Customer</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Amount</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Currency</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Status</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6 text-left">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Description</p>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Actions</p>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($payments as $payment)
                            <tr>
                                <td class="px-5 py-4 sm:px-6 text-gray-500 text-sm dark:text-gray-400 text-center">
                                    {{ $loop->index + $payments->firstItem() }}
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-left">
                                    <span class="block font-medium text-gray-800 text-sm dark:text-white/90">
                                        {{ $payment->name }}
                                    </span>
                                    <p class="text-gray-500 text-sm dark:text-gray-400">{{ $payment->email }}</p>
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-right">
                                    <p class="text-gray-500 text-sm dark:text-gray-400">
                                        {{ number_format($payment->amount, 2) }}
                                    </p>
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-center">
                                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                        {{ $payment->currency }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-center">
                                    <button
                                        wire:click="togglePaymentStatus('{{ $payment->id }}')"
                                        class="rounded-full px-3 py-1 text-xs font-medium transition-colors duration-200 {{ $payment->is_paid
                                                    ? 'bg-green-100 text-green-800 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50'
                                                    : 'bg-red-100 text-red-800 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50' }}"
                                        title="Click to toggle payment status"
                                    >
                                        {{ $payment->is_paid ? 'Paid' : 'Unpaid' }}
                                    </button>
                                </td>
                                <td class="px-5 py-4 sm:px-6 group/desc relative overflow-visible">
                                    <div class="hidden group-hover/desc:block cursor-default absolute z-999 bottom-1/2 left-0 translate-y-1/2 min-w-120px translate bg-white shadow-md border rounded px-2 py-1 text-sm font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300 w-full">
                                        {{ $payment->description }}
                                    </div>
                                    <p class="text-gray-500 text-sm dark:text-gray-400 truncate max-w-xs cursor-default">
                                        {{ Str::limit($payment->description, 20) }}
                                    </p>
                                </td>
                                <td class="px-5 py-4 sm:px-6 text-center">
                                    <div class="flex items-center justify-center gap-2 font-semibold text-sm">
                                        <a
                                            type="button"
                                            class="{{ $payment->is_paid ? "text-violet-300" : "text-violet-500"}}"
                                            @if(!$payment->is_paid) href="{{ route('payment', $payment->id) }}" @endif
                                            target="_blank"
                                        >
                                            Link
                                        </a>
                                        <button
                                            wire:click="viewPayment('{{ $payment->id }}')"
                                            class="rounded-lg text-green-500 px-1 py-0 text-sm font-medium hover:text-green-600 focus:outline-hidden"
                                        >
                                            View
                                        </button>
                                        <button
                                            wire:click="edit('{{ $payment->id }}')"
                                            class="rounded-lg text-blue-500 px-1 py-0 text-sm font-medium hover:text-blue-600 focus:outline-hidden"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            wire:click="confirmDelete('{{ $payment->id }}')"
                                            class="rounded-lg text-red-500 px-1 py-0 text-sm font-medium hover:text-red-600 focus:outline-hidden"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="mb-4 h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-gray-500 dark:text-gray-400">No payments found</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500">Get started by creating your
                                            first payment</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @endif

    <!-- View Payment Modal -->
    @if($showViewModal && $viewingPayment)
        <div class="fixed inset-0 z-99999 flex items-center justify-center bg-gray-900/50 p-4">
            <div
                class="w-full max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        Payment Details
                    </h3>
                    <button
                        wire:click="closeViewModal"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
                    >
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="space-y-4">

                    <div class="mb-4 dark:text-white">
                        ID: {{ $viewingPayment->id }}
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <!-- Name -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Name
                            </label>
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                {{ $viewingPayment->name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                {{ $viewingPayment->email }}
                            </div>
                        </div>

                        <!-- Amount -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Amount
                            </label>
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                {{ number_format($viewingPayment->amount, 2) }}
                            </div>
                        </div>

                        <!-- Currency -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Currency
                            </label>
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                {{ $viewingPayment->currency }}
                            </div>
                        </div>

                        <!-- Created Date -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Created Date
                            </label>
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                {{ $viewingPayment->created_at->format('M d, Y \a\t g:i A') }}
                            </div>
                        </div>

                        <!-- Updated Date (if different from created) -->
                        @if($viewingPayment->updated_at->ne($viewingPayment->created_at))
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Last Updated
                                </label>
                                <div
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                    {{ $viewingPayment->updated_at->format('M d, Y \a\t g:i A') }}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="w-full">
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Description
                        </label>
                        <div
                            class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90 min-h-[60px]">
                            {{ $viewingPayment->description }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        <!-- Payment Gateway -->
                        @if($viewingPayment->payment_gateway)
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Payment Gateway
                                </label>
                                <div
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90 capitalize">
                                    {{ $viewingPayment->payment_gateway }}
                                </div>
                            </div>
                        @endif

                        <!-- Payment ID -->
                        @if($viewingPayment->payment_id)
                            <div>
                                <label class="flex mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Payment ID
                                    <a href="{{ route('payment.details', $viewingPayment->id) }}" class="ml-auto text-blue-500" target="_blank">Details</a>
                                </label>
                                <div
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                    {{ $viewingPayment->payment_id }}
                                </div>
                            </div>
                        @endif

                        <!-- Paid At -->
                        @if($viewingPayment->paid_at)
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Paid At
                                </label>
                                <div
                                    class="rounded-lg border border-gray-200 bg-gray-50 px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-800 dark:text-white/90">
                                    {{ $viewingPayment->paid_at->format('M d, Y \a\t g:i A') }}
                                </div>
                            </div>
                        @endif

                        <!-- Status -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Payment Status
                            </label>
                            <div class="flex items-center gap-4">
                                <span class="rounded-full px-3 py-1 text-sm font-medium {{ $viewingPayment->is_paid
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' }}">
                                    {{ $viewingPayment->is_paid ? 'Paid' : 'Unpaid' }}
                                </span>

                                @if($viewingPayment->is_paid)
                                    <a class="text-blue-500 inline-flex items-center gap-1"
                                       href="https://dashboard.stripe.com/payments/{{$viewingPayment->payment_id}}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                             stroke-linejoin="round"
                                             class="inline">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"/>
                                            <path d="M11 13l9 -9"/>
                                            <path d="M15 4h5v5"/>
                                        </svg>
                                        Payment Info
                                    </a>
                                @endif
                            </div>
                        </div>

                        @if(!$viewingPayment->is_paid)
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Payment Link
                                </label>
                                <a class="text-blue-500 inline-flex items-center gap-1"
                                   href="{{ route('payment', $viewingPayment->id) }}" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="inline">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"/>
                                        <path d="M11 13l9 -9"/>
                                        <path d="M15 4h5v5"/>
                                    </svg>
                                    Payment Link
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Actions -->
                <div class="mt-6 flex justify-end gap-3">
                    <button
                        wire:click="edit('{{ $viewingPayment->id }}')"
                        class="rounded-lg bg-blue-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-blue-600 focus:outline-hidden focus:ring-3 focus:ring-blue-500/10"
                    >
                        Edit Payment
                    </button>
                    <button
                        wire:click="closeViewModal"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-hidden focus:ring-3 focus:ring-gray-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteConfirmation)
        <div
            x-data="{ show: true }"
            x-show="show"
            x-cloak
            class="fixed inset-0 z-99999 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div
                    x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 bg-gray-500/75 transition-opacity z-0"
                    @click="$wire.cancelDelete()"
                ></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div
                    x-show="show"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block transform overflow-hidden rounded-2xl bg-white px-4 pt-5 pb-4 text-left align-bottom shadow-xl transition-all dark:bg-gray-900 sm:my-8 sm:w-full sm:max-w-lg sm:p-6 sm:align-middle relative z-99"
                >
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white"
                                id="modal-title">
                                Delete Payment
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Are you sure you want to delete this payment? This action cannot be undone and will
                                    permanently remove the payment record from the system.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button
                            type="button"
                            wire:click="delete"
                            wire:loading.attr="disabled"
                            wire:target="delete"
                            class="inline-flex w-full justify-center items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-700 focus:outline-hidden focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                        <span wire:loading.remove wire:target="delete">
                            Delete Payment
                        </span>
                            <span wire:loading wire:target="delete" class="flex items-center">
                            <x-loading-spinner size="sm" color="white" class="mr-2"/>
                            Deleting...
                        </span>
                        </button>
                        <button
                            type="button"
                            wire:click="cancelDelete"
                            class="mt-3 inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-hidden focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-600 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto"
                        >
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
