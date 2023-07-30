<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
class SocialiteController extends Controller
{
   public function googleredirect(Request $request){
        return Socialite::driver('google')->redirect();
    }  
    public function googlecallback(Request $request){
      $userdata = Socialite::driver('google')->user();
        // $existingUser = User::where('email', $userdata->email,'password',$userdata)->first();
    
        // if ($existingUser) {
            
        //   return redirect()->route('login')->with('error', 'An account with this email already exists. Please login using your existing account or merge accounts.');
        // } 
        //     // User does not exist, proceed with social authentication
        $user = User::where('email',$userdata->email)->where('auth_type','google')->first();
        if ($user) {
            //do login
        Auth::login($user);
        return redirect('/tasks');
        }
        else
        {
            
        $uuid = Str::uuid()->toString(); //uuid = unique user id
        $user = new User();
        $user->name = $userdata->name;
        $user->email = $userdata->email;
        $user->password = Hash::make($uuid.now());
        $user->auth_type = 'google';
        $user->save();
        Auth::login($user);
        return redirect('/tasks');    
    }

    }  
}
