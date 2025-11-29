@extends('layouts.app')

@section('title', 'Account - Moneta')

@section('content')
<div class="space-y-6">
    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Profile Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Info -->
        <div class="lg:col-span-2 border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-6">Profile Information</h3>
            
            <div class="flex items-start gap-6 mb-6">
                <!-- User Avatar with Initial -->
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-3xl ring-4 ring-slate-100 dark:ring-slate-700">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h2 class="text-2xl font-medium text-slate-900 dark:text-slate-100">{{ Auth::user()->name }}</h2>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                            Active User
                        </span>
                    </div>
                    <p class="text-base text-slate-600 dark:text-slate-400 mb-4">{{ Auth::user()->email }}</p>
                    <div class="flex gap-2">
                        <butto 
                            onclick="enableEdit()"
                            id="editBtn"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium transition"
                        >
                            Edit Profile
                        </button>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <form action="{{ route('account.update') }}" method="POST" id="profileForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Full Name</label>
                        <input 
                            type="text" 
                            name="name"
                            value="{{ old('name', Auth::user()->name) }}" 
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-60 disabled:cursor-not-allowed"
                            disabled
                            id="nameInput"
                        >
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Email Address</label>
                        <input 
                            type="email" 
                            name="email"
                            value="{{ old('email', Auth::user()->email) }}" 
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-60 disabled:cursor-not-allowed"
                            disabled
                            id="emailInput"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Member Since</label>
                        <input 
                            type="text" 
                            value="{{ Auth::user()->created_at->format('F d, Y') }}" 
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none"
                            disabled
                        >
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Last Updated</label>
                        <input 
                            type="text" 
                            value="{{ Auth::user()->updated_at->format('F d, Y') }}" 
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none"
                            disabled
                        >
                    </div>
                </div>

                <!-- Save/Cancel Buttons (Hidden by default) -->
                <div class="mt-4 flex gap-2 hidden" id="editButtons">
                    <button 
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2 text-sm font-medium transition"
                    >
                        Save Changes
                    </button>
                    <button 
                        type="button"
                        onclick="cancelEdit()"
                        class="border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Account Stats -->
        <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-6">Account Stats</h3>
            
            <div class="space-y-4">
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Member Since</p>
                    <p class="text-base font-medium text-slate-900 dark:text-slate-100">
                        {{ Auth::user()->created_at->format('F Y') }}
                    </p>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Account Status</p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <p class="text-base font-medium text-slate-900 dark:text-slate-100">Active</p>
                    </div>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Account Type</p>
                    <p class="text-base font-medium text-slate-900 dark:text-slate-100">Free Account</p>
                </div>
                
                <div class="bg-slate-50 dark:bg-slate-800 rounded-xl p-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-1">Email Verified</p>
                    <p class="text-base font-medium text-slate-900 dark:text-slate-100">
                        @if(Auth::user()->email_verified_at)
                            <span class="text-green-600 dark:text-green-400">✓ Verified</span>
                        @else
                            <span class="text-orange-600 dark:text-orange-400">Not Verified</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Security -->
        <div class="border border-slate-200 dark:border-slate-700 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100 mb-4">Security</h3>
            <div class="space-y-3">
                <button onclick="openChangePasswordModal()" class="w-full flex items-center justify-between p-3 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-slate-900 dark:text-slate-100">Change Password</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Update your password</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <button class="w-full flex items-center justify-between p-3 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition opacity-50 cursor-not-allowed">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-slate-900 dark:text-slate-100">Two-Factor Authentication</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Coming soon</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="border border-red-200 dark:border-red-800 shadow-lg rounded-2xl p-6 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-medium text-red-600 dark:text-red-400 mb-4">Danger Zone</h3>
            <div class="space-y-3">
                <button onclick="openDeleteAccountModal()" class="w-full flex items-center justify-between p-3 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-slate-900 dark:text-slate-100">Delete Account</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Permanently delete your account</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-md w-full border border-slate-200 dark:border-slate-700 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-medium text-slate-900 dark:text-slate-100">Change Password</h3>
                <button onclick="closeChangePasswordModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form action="{{ route('account.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Current Password</label>
                        <input 
                            type="password" 
                            name="current_password"
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        >
                        @error('current_password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">New Password</label>
                        <input 
                            type="password" 
                            name="password"
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        >
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @else
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Minimum 8 characters</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">Confirm New Password</label>
                        <input 
                            type="password" 
                            name="password_confirmation"
                            class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            required
                        >
                    </div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button 
                        type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg px-4 py-2.5 text-sm font-medium transition"
                    >
                        Update Password
                    </button>
                    <button 
                        type="button"
                        onclick="closeChangePasswordModal()"
                        class="flex-1 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div id="deleteAccountModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-2xl max-w-md w-full border border-red-200 dark:border-red-800 max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-medium text-slate-900 dark:text-slate-100">Delete Account</h3>
                </div>
                <button onclick="closeDeleteAccountModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Warning -->
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                <p class="text-sm text-red-700 dark:text-red-400 font-medium mb-2">⚠️ This action cannot be undone!</p>
                <ul class="text-xs text-red-600 dark:text-red-400 space-y-1">
                    <li>• All your data will be permanently deleted</li>
                    <li>• All categories will be removed</li>
                    <li>• All transactions will be removed</li>
                </ul>
            </div>

            <form action="{{ route('account.destroy') }}" method="POST" id="deleteAccountForm">
                @csrf
                @method('DELETE')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-600 dark:text-slate-400 mb-2">
                        Enter your password to confirm
                    </label>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="Enter your password"
                        class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-500"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button 
                        type="submit"
                        onclick="return confirm('Are you absolutely sure? Type YES to confirm.')"
                        class="flex-1 bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-2.5 text-sm font-medium transition"
                    >
                        Yes, Delete My Account
                    </button>
                    <button 
                        type="button"
                        onclick="closeDeleteAccountModal()"
                        class="flex-1 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition"
                    >
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Edit Profile Functions
function enableEdit() {
    document.getElementById('nameInput').disabled = false;
    document.getElementById('emailInput').disabled = false;
    document.getElementById('editButtons').classList.remove('hidden');
    document.getElementById('editBtn').classList.add('hidden');
}

function cancelEdit() {
    document.getElementById('nameInput').disabled = true;
    document.getElementById('emailInput').disabled = true;
    document.getElementById('editButtons').classList.add('hidden');
    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('profileForm').reset();
}

// Change Password Modal Functions
function openChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeChangePasswordModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Delete Account Modal Functions
function openDeleteAccountModal() {
    document.getElementById('deleteAccountModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDeleteAccountModal() {
    document.getElementById('deleteAccountModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside
document.getElementById('changePasswordModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeChangePasswordModal();
});

document.getElementById('deleteAccountModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeDeleteAccountModal();
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeChangePasswordModal();
        closeDeleteAccountModal();
    }
});

// Auto-open modal if there's validation error
@if(session('modal') == 'changePassword')
    openChangePasswordModal();
@endif

@if(session('modal') == 'deleteAccount')
    openDeleteAccountModal();
@endif
</script>
@endsection