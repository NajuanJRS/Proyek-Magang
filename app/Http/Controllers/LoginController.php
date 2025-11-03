<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function index(): View
    {
        return view('login');
    }

    /**
     * Proses login user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $request->name)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            $user->remember_token = Str::random(60);
            $user->save();

            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                default => redirect()->route('login')
                    ->withErrors(['role' => 'Role tidak dikenali.']),
            };
        }

        return back()->withErrors([
            'name' => 'Username atau Password yang anda masukkan salah.',
        ])->withInput();
    }

    /**
     * Logout user.
     */
    public function destroy(Request $request)
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());
            $user->remember_token = null;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
