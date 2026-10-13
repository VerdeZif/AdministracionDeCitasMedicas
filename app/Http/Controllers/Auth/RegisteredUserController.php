<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'document_type' => ['required', 'string', 'max:10'],
            'dni' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'last_name_paternal' => ['required', 'string', 'max:255'],
            'last_name_maternal' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'birth_date' => ['required', 'date', 'before:today'],
            'phone' => ['required', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:M,F'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'document_type' => $request->document_type,
            'dni' => $request->dni,
            'name' => $request->name,
            'last_name_paternal' => $request->last_name_paternal,
            'last_name_maternal' => $request->last_name_maternal,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'role' => 'patient', // Exclusivo para pacientes
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
