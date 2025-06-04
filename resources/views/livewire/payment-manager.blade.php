<div>
    <x-slot name="header">
        <x-breadcrumb page-name="Payments"/>
    </x-slot>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-6 rounded-lg border border-success-300 bg-success-50 p-4 dark:border-success-700 dark:bg-success-500/15">
            <div class="flex items-center">
                <svg class="mr-3 h-5 w-5 text-success-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm font-medium text-success-700 dark:text-success-500">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Header Section -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white/90">Payment Management</h2>

        <button wire:click="showCreateForm"
            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10">
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
                        fill="" />
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search payments..."
                class="h-11 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-4 pl-12 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-800 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800" />
        </div>
    </div>

    <!-- Form Modal -->
    @if($showForm)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4">
            <div
                class="w-full max-w-2xl rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <div class="mb-6 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white/90">
                        {{ $editingPaymentId ? 'Edit Payment' : 'Create Payment' }}
                    </h3>
                    <button wire:click="hideForm"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
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
                            <input type="text" wire:model="name"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('name') border-error-300 dark:border-error-700 @enderror"
                                placeholder="Enter name" />
                            @error('name')
                                <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Email
                            </label>
                            <input type="email" wire:model="email"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('email') border-error-300 dark:border-error-700 @enderror"
                                placeholder="Enter email" />
                            @error('email')
                                <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Amount Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Amount
                            </label>
                            <input type="number" step="0.01" wire:model="amount"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('amount') border-error-300 dark:border-error-700 @enderror"
                                placeholder="0.00" />
                            @error('amount')
                                <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Currency Field -->
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Currency
                            </label>
                            <select wire:model="currency"
                                class="h-11 w-full appearance-none rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 pr-11 text-sm text-gray-800 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 @error('currency') border-error-300 dark:border-error-700 @enderror">
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
                        <textarea wire:model="description" rows="4"
                            class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 @error('description') border-error-300 dark:border-error-700 @enderror"
                            placeholder="Enter description"></textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-error-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="hideForm"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-hidden focus:ring-3 focus:ring-gray-500/10 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <button type="submit"
                            class="rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10">
                            {{ $editingPaymentId ? 'Update' : 'Create' }} Payment
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
                                    <div class="flex items-center">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Name</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Email</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Amount</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Currency</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Description</p>
                                    </div>
                                </th>
                                <th class="px-5 py-3 sm:px-6">
                                    <div class="flex items-center">
                                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Actions</p>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <!-- Table Body -->
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @forelse($payments as $payment)
                                <tr>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center">
                                            <span class="block font-medium text-gray-800 text-sm dark:text-white/90">
                                                {{ $payment->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-sm dark:text-gray-400">{{ $payment->email }}</p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-sm dark:text-gray-400 text-right">
                                            {{ number_format($payment->amount, 2) }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <span
                                            class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                            {{ $payment->currency }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <p class="text-gray-500 text-sm dark:text-gray-400 truncate max-w-xs">
                                            {{ Str::limit($payment->description, 30) }}
                                        </p>
                                    </td>
                                    <td class="px-5 py-4 sm:px-6">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="edit({{ $payment->id }})"
                                                class="rounded-lg bg-blue-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-blue-600 focus:outline-hidden focus:ring-2 focus:ring-blue-500/20">
                                                Edit
                                            </button>
                                            <button wire:click="delete({{ $payment->id }})"
                                                wire:confirm="Are you sure you want to delete this payment?"
                                                class="rounded-lg bg-red-500 px-3 py-1.5 text-xs font-medium text-white hover:bg-red-600 focus:outline-hidden focus:ring-2 focus:ring-red-500/20">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-8 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="mb-4 h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
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
</div>
