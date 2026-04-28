<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(): Response|RedirectResponse
    {
        if ($redirect = $this->redirectForAuthenticatedUser()) {
            return redirect()->to($redirect);
        }

        return response()
            ->view('front.login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
    }

    public function login(Request $request): RedirectResponse
    {
        if ($redirect = $this->redirectForAuthenticatedUser()) {
            return redirect()->to($redirect);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (
            Auth::guard('admin')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'is_active' => 1,
            ], $remember)
        ) {
            $request->session()->regenerate();

            return redirect()->intended('/admin');
        }

        if (
            Auth::guard('author')->attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password'],
                'is_active' => 1,
            ], $remember)
        ) {
            $request->session()->regenerate();

            return redirect()->intended('/author');
        }

        return back()
            ->withErrors([
                'email' => 'Invalid credentials or inactive account.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('author')->check()) {
            Auth::guard('author')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function redirectForAuthenticatedUser(): ?string
    {
        if (Auth::guard('admin')->check()) {
            return '/admin';
        }

        if (Auth::guard('author')->check()) {
            return '/author';
        }

        return null;
    }
}
