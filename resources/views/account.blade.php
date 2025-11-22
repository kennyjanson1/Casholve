@extends('layouts.app')

@section('title', 'Account - Moneta')

@section('content')
<div class="space-y-6">
    <!-- Profile Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="lg:col-span-2 border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-6">Profile Information</h3>
            
            <div class="flex items-start gap-6 mb-6">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&h=200&fit=crop" alt="Profile" class="w-24 h-24 rounded-full ring-4 ring-slate-100 dark:ring-slate-700">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-2xl font-medium text-slate-900 dark:text-slate-100">Jhonson Mick</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Premium User</span>
                    </div>
                    <p class="text-base text-slate-600 dark:text-slate-400 mb-4">jhonson.mick@example.com</p>
                    <div class="flex gap-2">
                        <button class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium">Edit Profile</button>
                        <button class="border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800">Change Password</button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Full Name</label>
                    <input type="text" value="Jhonson Mick" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Email Address</label>
                    <input type="email" value="jhonson.mick@example.com" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Phone Number</label>
                    <input type="tel" value="+1 (555) 123-4567" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Location</label>
                    <input type="text" value="New York, USA" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>
        </div>

        <!-- Account Stats -->
        <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-6">Account Stats</h3>
            
            <div class="space-y-4">
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Member Since</p>
                    <p class="text-base font-medium text-slate-900 dark:text-slate-100">January 2023</p>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Total Transactions</p>
                    <div class="flex items-center justify-between">
                        <p class="text-base font-medium text-slate-900 dark:text-slate-100">1,234</p>
                        <span class="text-green-500 flex items-center gap-1 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            12%
                        </span>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Linked Accounts</p>
                    <p class="text-base font-medium text-slate-900 dark:text-slate-100">3 Accounts</p>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Active Goals</p>
                    <p class="text-base font-medium text-slate-900 dark:text-slate-100">5 Goals</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Note: Additional sections (Bank Accounts, Recent Activity) would follow the same pattern -->
</div>
@endsection
