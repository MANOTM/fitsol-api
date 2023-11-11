<?php

namespace App\Http\Controllers;

use Socialite;
use Carbon\Carbon;
use App\Models\User;

use App\Mail\VerifyToken;

use App\Models\VerifyEmail;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
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

        User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => $HashPass,
        ]);

        $token = rand(100000, 999999);

        VerifyEmail::create([
            'email'=>$request->email,
            'token'=>$token
        ]);

        Mail::to($request->email)->send(new VerifyToken($token));

        return $this->response([],'Email Sent successfully');
    }

    public function verifyToken(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:verify_emails',
            'token' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->response([],$validator->errors(),400);
        }

        $VerifyEmail=VerifyEmail::where('email',$request->email)->first();
        $createdAt = Carbon::parse($VerifyEmail->created_at);
        $twoHoursAgo = Carbon::now()->subHours(2);

        if ($createdAt->lessThan($twoHoursAgo)) {
            return $this->response([],'Token expire',400);
        }
        if( $VerifyEmail->token!=$request->token  ){
            return $this->response([],'Token invalid or expire',400);
        }
        $user=User::Where('email',$request->email)->first();
        $user->update([
            'email_verified_at'=>Carbon::now()
        ]);
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
        $user = User::Where('email',$request->email)->first();
        $user->tokens()->delete();
        if(is_null($user->email_verified_at)){
            return $this->response([],'Email not verified');
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        $user->token=$token;
        return $this->response($user,'login successfully');
    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return $this->response([],'successfully');
    }
}
