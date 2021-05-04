<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller {
    public function login(Request $request) {

        if($request->isMethod('post')) {
            //*returns an array with the submitted data
            //dd($request->all());

            //validate request
            $this->validate($request, [
                'email'=> 'required|email',
                'password'=>'required'
            ]);


            //verify and find user
            $user = User::where('email', $request->input('email'))->first();

            if(!$user || !Hash::check($request->input('password'), $user->password)) {
                return redirect(route('login'))->withErrors([
                    'login' => 'Email or password is incorrect'
                ])->withInput();
            }
            
            //login user

            Auth::login($user);

            return redirect('/dashboard');
        }
        

        //for the get req
        return view('auth/login');
    }

    public function register(Request $request) {
        //TODO
        if($request->isMethod('post')) {
            //validate request
            $this->validate($request, [
                'name'=> 'required',
                'email'=> 'required|email',
                'password' => 'min:6|required_with:password2',
                'password2' => 'min:6|same:password'
            ]);

            //create user
            $user = User::create([
                'name'=> $request->input('name'),
                'email'=> $request->input('email'),
                'password'=> $request->input('password')
            ]);

            //login user or send activate email
            Auth::login($user);

            // redirect to dashboard/login
            return redirect('/dashboard');
        }

        //return view register
        return view('auth/register');
    }
}