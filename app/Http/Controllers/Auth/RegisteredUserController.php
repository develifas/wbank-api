<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Ramsey\Uuid\Uuid;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:11', 'min:11'],
            'birthday' => ['required', 'date'],
            'mother' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:11', 'min:11'],
            'zipcode' => ['required', 'string', 'max:8', 'min:8'],
            'state' => ['required', 'string', 'max:2', 'min:2'],
            'city' => ['required', 'string', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'number' => ['string'],
            'public_place' => ['string', 'max:255'],
            'complement' => ['string', 'max:255'],
        ]);

        $user = User::create([
            'uid' => Uuid::uuid4(),
            'name' => $request->name,
            'cpf' => $request->cpf,
            'birthday' => $request->birthday,
            'mother' => $request->mother,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'zipcode' => $request->zipcode,
            'state' => $request->state,
            'city' => $request->city,
            'district' => $request->district,
            'address' => $request->address,
            'number' => $request->number,
            'public_place' => $request->public_place,
            'complement' => $request->complement,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
