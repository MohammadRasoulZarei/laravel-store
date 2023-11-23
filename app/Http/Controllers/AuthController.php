<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\OtpSms;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{


    public function redirectToProvider($provider)
    {

        return Socialite::driver($provider)->redirect();
    }

    public function providerCallback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();
        } catch (\Throwable $th) {
            alert()->warning("هنگام ارتباط خطا رخ داده لطفا دوباره امتحان کنید", 'خطا')->showConfirmButton('باشه');
            return redirect()->route('login');
        }
        //dd()
        $user = User::where('email', $providerUser->getEmail())->first();
        if (!$user) {
            $user = User::create([
                'name' => $providerUser->getName(),
                'email' => $providerUser->getEmail(),
                'provider_name' => $provider,
                'avatar' => $providerUser->getAvatar(),
                'password' => Hash::make($providerUser->getId()),
                'email_verified_at' => Carbon::now()
            ]);
        } else {
            $user->update(

                [
                    'email_verified_at' => Carbon::now(),
                    'avatar' => $providerUser->getAvatar(),
                ]
            );
        }
        auth()->login($user, $remember = true);
        alert()->success("لاگین با موفقیت انجام شد.", 'باتشکر')->showConfirmButton('باشه');
        return redirect()->route('home.index');
    }

    #the other way of authentication
    public function phoneLogin()
    {

        if (request()->method() == 'GET') {


            return view('auth.phone_login');
        }
        request()->validate([
            'phone' => 'required|iran_mobile'
        ]);
        try {
            $user = User::where('cellphone', request('phone'))->first();
            $otp = rand(1000, 9999);
            $login_token = Hash::make(request('phone'));
            if ($user) {
                $user->update([
                    'otp' => $otp,
                    'login_token' => $login_token
                ]);
                $user->notify(new OtpSms($otp));
                return response(['login_token' => $login_token], 200);
            } else {
                return 0;
            }
        } catch (\Throwable $th) {
            return response(['errors' => $th->getMessage()]);
        }

    }

    public function checkOtp(Request $req)
    {
        $req->validate([
            'otp' => 'required|digits:4',
            'login_token' => 'required'
        ]);

        $user = User::where('login_token', $req->login_token)->first();
        if ($user->otp == $req->otp) {
            auth()->login($user, $remember = true);
            return true;
        } else {
            return response(['errors' => ['otp' => ['کد تاییدیه نادرست است']]],422);
        }
    }
    public function resendOtp(Request $req)
    {
        $otp = rand(1000, 9999);
        $login_token = Hash::make('jhghih@gfdg6!ewadfjdkl');
        try {
            $user
                = User::where('login_token', $req->login_token)->first();
            $user->update([
                'otp' => $otp,
                'log' => $login_token

            ]);
            $user->notify(new OtpSms($otp));
            return response(['login_token' => $login_token], 200);
        } catch (\Throwable $th) {
            return response(['errors' => $th->getMessage()]);
        }
    }
}
