<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Login;
use Auth;

class LoginController extends Controller
{       
    public function __construct()
    {
        $this->middleware('guest')->except('logout','authenticate');
    }
    public function loginForm()
    {        
        return view('login.form');    
    }

    public function authenticate(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    			'username' => 'required',
    			'password' => 'required'
    		]);

    	if($validator->fails())
    	{
    		return redirect('login.form')->withErrors($validator)->withInput(['username'=>$request->username]);
    	}

    	if(Auth::guard('admin')->attempt(['email' => $request->username,'password'=>$request->password]))
    	{
    		return redirect()->route('admin.dashboard');
    	}
    	else
    	{
    		return redirect()->route('login.form')->with('error','Invalid Credentials. Please try again.');
    	}
    }

    public function logout()
    {
    	Auth::guard('admin')->logout();

    	return redirect()->route('login.form')->with('error','Successfully Logged Out');
    }
}
