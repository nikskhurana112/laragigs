<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //show user Register
    public function create()
    {
        return view('users.register');
    }
    public function store(Request $request)
    {

        $formFields = $request->validate(
            [
                'name' => 'required | min: 3',
                'email' => 'required | email | unique:users,email',
                'password' => 'required | confirmed | min: 6 '
            ]
        );
        //Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        $user =  User::create($formFields);

        //Login
        auth()->login($user);

        return redirect('/')->with('message', "user created and logged in");
    }

    public function logout(Request $request)
    {

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User logout successful');
    }

    public function login()
    {

        return view('users.login');
    }
    //Authenticate user
    public function authenticate(Request $request)
    {

        $formFields = $request->validate(
            [

                'email' => 'required | email ',
                'password' => 'required'
            ]
        );

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect('/')->with('message', 'User login successful');
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
