<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private function redirectPourRole($user)
    {
        return $user->role === 'staff' ? route('appointments.index') : route('appointments.create');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect($this->redirectPourRole(Auth::user()));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'Connecté avec succès.',
                'redirect' => $this->redirectPourRole(Auth::user()),
            ]);
        }

        return response()->json(['message' => 'Email ou mot de passe incorrect.'], 401);
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect($this->redirectPourRole(Auth::user()));
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client', // toute inscription publique = client
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Compte créé avec succès.',
            'redirect' => route('appointments.create'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showCreateStaff(Request $request)
{
    if ($request->user()->role !== 'staff') {
        abort(403, 'Accès réservé au personnel.');
    }
    return view('staff.create');
}

public function storeStaff(Request $request)
{
    if ($request->user()->role !== 'staff') {
        abort(403, 'Accès réservé au personnel.');
    }

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
    ]);

    User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => 'staff',
    ]);

    return redirect()->route('appointments.index')->with('success', 'Nouveau compte staff créé !');
}
}