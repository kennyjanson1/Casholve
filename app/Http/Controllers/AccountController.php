<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AccountController extends Controller
{
    /**
     * Display account page
     */
    public function index()
    {
        return view('account.index');
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        // Update user
        $user->update($validated);

        return redirect()->route('account')->with('success', 'Profile berhasil diperbarui!');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'current_password' => ['required', 'current_password'],
                'password' => ['required', 'confirmed', 'min:8'],
            ], [
                'current_password.current_password' => 'Password saat ini salah.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
            ]);

            // Update password
            Auth::user()->update([
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->route('account')->with('success', 'Password berhasil diubah!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('account')
                ->withErrors($e->errors())
                ->with('modal', 'changePassword');
        }
    }

    /**
     * Delete user account
     */
    public function destroy(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required', 'current_password'],
            ], [
                'password.current_password' => 'Password salah.',
            ]);

            $user = Auth::user();

            // Logout user
            Auth::logout();

            // Delete user (cascade akan hapus categories & transactions)
            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Akun Anda berhasil dihapus.');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('account')
                ->withErrors($e->errors())
                ->with('modal', 'deleteAccount');
        }
    }
}