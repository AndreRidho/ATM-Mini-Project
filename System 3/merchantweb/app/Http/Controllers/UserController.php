<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function create() {
        return view('register');
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6'],
            'accnum' => ['required']
        ]);

        $response = Http::post('http://localhost:8080/atm2/CheckValidAccServlet?acc-num='.$formFields['accnum']);

        if($response == "Success"){

            $formFields['password'] = bcrypt($formFields['password']);

            $user = User::create($formFields);

            auth()->login($user);

            return redirect('/')->with('message', 'User created and logged in');

        }

        return back()->withErrors(['accnum' => 'Invalid account number'])->onlyInput('accnum');

    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out');
    }

    public function login() {
        return view('login');
    }

    public function authenticate(Request $request) {
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');

    }
}
