<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Auth;
use Log;
use DB;
use Mail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/balances';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'referral_code' => $data['referral_code']
        ]);
    }

    public function resendToken(Request $request){
      $email = $request->input('resend_email');
      Log::info($email);
      $user = User::where('email', $email)->first();
      if ($user){
        $user = $user->toArray();
        Log::info($user);
        $user['link'] = str_random(30);
        DB::table('user_activations')->where('id_user', $user['id'])->update(['token'=>$user['link']]);

        Mail::send('emails.activation', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Site - Activation Code');
        });
        return redirect()->to('login')->with('warning',"Resent successfully!");
      }
      return redirect()->to('login')->with('warning',"Resending failed!");
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $validator = $this->validator($input);
        $email = $request->input('email');
        Log::info('register-'.$email);

        if ($validator->passes()) {
            $user = $this->create($input)->toArray();
            $referral_code = $request->input('referral_code');
            if ($referral_code != ''){
                $referred_id = explode('referral-', $referral_code)[1];
                $referrer = User::where('id', $referred_id)->first();

                if ($referrer){
                  DB::table('referrals')->insert(['user_id'=>$user['id'],'referred_by'=>$referred_id]);
                }
            }
            $user['link'] = str_random(30);

            DB::table('user_activations')->where(['id_user' => $user['id']])->delete();
            DB::table('user_activations')->insert(['id_user'=>$user['id'],'token'=>$user['link']]);

            Mail::send('emails.activation', $user, function($message) use ($user) {
                $message->to($user['email']);
                $message->subject('Site - Activation Code');
            });

            if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
            {
                Log::info('signin-'.$email);
                if(auth()->user()->is_activated != 1){
                    Auth::logout();
                    return redirect()->to('login')->with('warning',"First please check your email and active your account.");
                }
                return redirect()->to('home');
            }
        }
        return back()->with('errors',$validator->errors());
    }

    public function userActivation($token)
    {
        $check = DB::table('user_activations')->where('token',$token)->first();

        if(!is_null($check)){
            $user = User::find($check->id_user);

            if($user->is_activated == 1){
                return redirect()->to('login')
                    ->with('success',"user are already actived.");
            }

            $user['is_activated'] = 1;
            $user->save();
            DB::table('user_activations')->where('token',$token)->delete();

            return redirect()->to('login')
                ->with('success',"user active successfully.");
        }

        return redirect()->to('login')->with('warning',"your token is invalid.");
    }

    public function RandomString()
    {
        $characters = '123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $randstring.$characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }

    public function forgetpassword(Request $request){
      $email = $request->input('email');
      $user = User::where('email', $email)->first();
      if (isset($user->id)){
        $password = $this->RandomString();
        $user->password = bcrypt($password);
        $user->save();
        $user = $user->toArray();
        $user['password'] = $password;
        Mail::send('emails.forgetpassword', $user, function($message) use ($user) {
            $message->to($user['email']);
            $message->subject('Site - Reset Password');
        });
        return back()->with('success', 'We have sent password to your email!');
      }
      return back()->with('failed', 'Your email is not registered yet!');
    }
}
