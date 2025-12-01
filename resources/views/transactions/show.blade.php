@extends('layouts.app')

@section('title', 'Transaction Detail - Moneta')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100">Transaction Detail</h1>
            <p class="text-slate-600 dark:text-slate-400">View transaction information</p>
        </div>
        <a href="{{ route('transactions.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
    </div>

    <!-- Transaction Info Card -->
    <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
        <!-- Header with Icon and Title -->
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-3xl">
                    {{ $transaction->category->icon ?? '📝' }}
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-slate-900 dark:text-slate-100">{{ $transaction->title }}</h2>
                    <p class="text-slate-600 dark:text-slate-400">{{ $transaction->category->name ?? 'Uncategorized' }}</p>
                </div>
            </div>
            
            <!-- Type Badge -->
            <span class="px-3 py-1 rounded-lg text-sm font-medium {{ $transaction->type === 'income' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                {{ ucfirst($transaction->type) }}
            </span>
        </div>

        <!-- Amount Display -->
        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-6 mb-6">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Amount</p>
            <p class="text-4xl font-bold {{ $transaction->type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                {{ $transaction->type === 'income' ? '+' : '-' }}Rp {{ number_format($transaction->amount, 0, ',', '.') }}
            </p>
        </div>

        <!-- Transaction Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Date -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Date</p>
                <p class="text-lg text-slate-900 dark:text-slate-100">
                    {{ $transaction->date->format('d M Y') }}
                </p>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    {{ $transaction->date->diffForHumans() }}
                </p>
            </div>

            <!-- Category -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Category</p>
                <div class="flex items-center gap-2">
                    <span class="text-2xl">{{ $transaction->category->icon ?? '📝' }}</span>
                    <span class="text-lg text-slate-900 dark:text-slate-100">
                        {{ $transaction->category->name ?? 'Uncategorized' }}
                    </span>
                </div>
            </div>

            <!-- Created At -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Created At</p>
                <p class="text-lg text-slate-900 dark:text-slate-100">
                    {{ $transaction->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            <!-- Updated At -->
            <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Last Updated</p>
                <p class="text-lg text-slate-900 dark:text-slate-100">
                    {{ $transaction->updated_at->format('d M Y, H:i') }}
                </p>
            </div>
        </div>

        <!-- Description -->
        @if($transaction->description)
        <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4 mb-6">
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-2">Description</p>
            <p class="text-slate-900 dark:text-slate-100">{{ $transaction->description }}</p>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-6 border-t border-slate-200 dark:border-slate-700">
            <a href="{{ route('transactions.edit', $transaction->id) }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2.5 text-sm font-medium transition text-center">
                Edit Transaction
            </a>
            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to delete this transaction?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-2.5 text-sm font-medium transition">
                    Delete Transaction
                </button>
            </form>
            <a href="{{ route('transactions.index') }}" class="flex-1 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition text-center">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection