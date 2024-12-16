<?php

namespace App\Http\Controllers;

use App\Models\PasswordResetToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register()
    {
        return view('login.registerpage');
    }

    public function loadlogin()
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        } elseif (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        } else {
            return view('login.loginpage');
        }
    }

    public function googleLogin()
    {
        // dd('heeloo');
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            // dd('hello');
            $user = Socialite::driver('google')->user();

            $is_user = User::where('email', $user->getEmail())->first();
            if (!$is_user) {
                $saveUser = User::updateOrCreate([
                   
                    
                ], [
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    // 'password' => Hash::make($user->getName() . '@' . $user->getId()),
                ]);
            } else {
                $saveUser = User::where('email', $user->getEmail())->update([
                    'google_id' => $user->getid(),
                ]);

                $saveUser = User::where('email', $user->getEmail())->first();
            }

            Auth::loginUsingId($saveUser->id);
            session()->put('id', $saveUser->id);
            session()->put('name', $saveUser->name);
            if (Auth::user()->is_admin == 1) {

                return redirect('/admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
        } catch (\Throwable $e) {
            throw $e;
        }

    }

    public function studentregister(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'number' => 'required',
        ]);
        if ($validate->fails()) {
            // dd('hello');
            return back()->with(['errors' => $validate->errors()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->number = $request->number;
        $user->password = $request->password;
        $user->save();

        $request->session()->put('id', $user->id);
        $request->session()->put('name', $user->name);
        $request->session()->put('number', $user->number);

        return redirect('/dashboard');

    }

    public function logincheck(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validate->fails()) {
            return back()->with(['errors' => $validate->errors()], 422);
        }

        $userCredential = $request->only('email', 'password');
        if (Auth::attempt($userCredential)) {

            $user = User::where('email', $request->email)->first();
            $request->session()->put('id', $user->id);
            $request->session()->put('name', $user->name);

            if (Auth::user()->is_admin == 1) {

                return redirect('/admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
        } else {
            return back()->with('errors', 'Username & password incorrect');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('id');
        $request->session()->forget('name');
        $request->session()->forget('number');
        Auth::logout();
        return redirect('/');

    }

    public function forgetpasswordload()
    {
        return view('login.forgetpassword');

    }
    public function forgetpassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (isset($user)) {

            $token = str::random(40);
            $domain = Url::to('/');
            $url = $domain . '/reset-password?token=' . $token;

            $data['url'] = $url;
            $data['email'] = $request->email;
            $data['title'] = 'Reset password';
            $data['body'] = 'You have requested to reset your password. Click the button below to reset it:';

            Mail::send('login.sentpasswordmail', compact('data'), function ($mess) use ($data) {
                $mess->to($data['email'])->subject($data['title']);
            });

            $resetpassword = new PasswordResetToken();
            $resetpassword->email = $request->email;
            $resetpassword->token = $token;
            $resetpassword->created_at = Carbon::now();
            $resetpassword->save();

            return back()->with('success', 'check your mail');

        } else {
            return back()->with('errors', 'Email does not exist');
        }

    }

    public function resetpasswordload(Request $request)
    {
        dd($request->all());
        $resetpassword = PasswordResetToken::where('token', $request->token)->first();
        if ($resetpassword) {
            $user = User::where('email', $resetpassword->email)->first();
            // dd($user);
            return view('login.resetpassword', ['user' => $user]);
        } else {
            // Handle case where the token does not exist
            dd('Token not found or does not exist');
        }

    }

    public function resetpassword(Request $request)
    {

        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find($request->id);

        // dd($user);
        if ($user) {

            $user->password = Hash::make($request->password);
            $user->save();

            PasswordResetToken::where('email', $user->email)->delete();

            return redirect('/')->with('success', 'pssword reset successfully');
        } else {
            print_r('somthing wrong');
        }

    }
}
