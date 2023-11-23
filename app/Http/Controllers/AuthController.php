<?php

namespace App\Http\Controllers;

use Socialite;
use Carbon\Carbon;
use App\Models\User;

use App\Mail\VerifyToken;

use App\Models\VerifyEmail;
use Illuminate\Support\Str;
use App\Mail\ForgetPassword;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Traits\HttpResponses;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use HttpResponses;

    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:25',
            'lname' => 'required|string|max:25',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }
        $HashPass=Hash::make($request->password);

        $user= User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => $HashPass,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        Mail::to($request->email)->send(new VerifyToken(env('APP_DOMAIN').'login?token='.$token));

        return $this->response([],'Email Sent successfully');
    }

    public function verifyToken(Request $request){

        auth()->user()->update([
            'email_verified_at'=>Carbon::now()
        ]);
        return $this->response([auth()->user()],'okok');

        auth()->user()->tokens()->delete();
        return $this->response([],'Email Verify successfully');
    }

    public function resentToken(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:verify_emails',
        ]);

        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }

        $token = rand(100000, 999999);

        VerifyEmail::where('email',$request->email)->first()->update([
            'created_at'=>Carbon::now(),
            'token'=>$token
        ]);

        Mail::to($request->email)->send(new VerifyToken($token));

        return $this->response([],'Email Sent successfully');
    }

    public function login (Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->response([],'Invalid login details',401);
        }
        $user =new UserResource(User::Where('email',$request->email)->first());

        $user->tokens()->delete();
        if(is_null($user->email_verified_at)){
            return $this->response([],'Email not verified',401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token=$token;
        return $this->response($user,'login successfully');
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return $this->response([],'successfully');
    }
    public function me(){
        $user =new UserResource(User::Where('email',auth()->user()->email)->first());
        return $this->response($user,'successfully');
    }
    public function FotgertPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users',
        ]);

        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }
        $token=Str::random(30);
        PasswordReset::updateOrCreate(
            ['email'=>$request->email],
            ['token'=>$token]
        );
        Mail::to($request->email)->send(new ForgetPassword(env('APP_DOMAIN').'reset?token='.$token.'&email='.$request->email));
        return $this->response([],'Email Sent successfully');
    }
    public function CheckToken(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:password_reset_tokens',
            'token'=>'required|string',
        ]);

        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }

        $password_check=PasswordReset::Where('email',$request->email)->first();
        if($password_check->token!=$request->token){
            return $this->response([],'incorect',401);
        }
        return $this->response([],'good');

    }
    public function resetPassword(Request $request ){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:users',
            'token' => 'required|string',
            'fpassword'=>'required|min:5',
            'spassword'=>'required|min:5|same:fpassword',
        ]);

        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }
        $password_check=PasswordReset::Where('email',$request->email)->first();
        if($password_check->token!=$request->token){
            return $this->response([],'incorect',401);
        }
        $user=User::Where('email',$request->email)->first();
        $user->password=Hash::make($request->fpassword);
        $user->save();
        return $this->response([],'password update successfully');

    }
}
