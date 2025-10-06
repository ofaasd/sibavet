<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use App\Providers\RouteServiceProvider;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Find the user by their email
        $user = User::where('email', $request->email)->first();

        // 2. If no user is found, immediately fail.
        if (!$user) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $passwordMatches = false;

        // 3. Check if the stored hash is a modern Bcrypt hash.
        // Modern hashes are 60 chars and start with '$2y$'.
        if (strlen($user->password) === 60 && str_starts_with($user->password, '$2y$')) {
            // It's a modern hash, use Laravel's standard Hash::check.
            $passwordMatches = Hash::check($request->password, $user->password);
        } else {
            // It's an OLD hash. Check it manually.
            // IMPORTANT: If your old system used SHA1, change md5() to sha1()
            $passwordMatches = (md5($request->password) === $user->password);
        }

        // 4. If the password was correct (either old or new format), log the user in.
        if ($passwordMatches) {
            Auth::login($user, $request->boolean('remember'));

            // IMPORTANT: If it was an old hash, upgrade it to Bcrypt now.
            if (strlen($user->password) < 60) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        // 5. If we reach here, the password was incorrect.
        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
