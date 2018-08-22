<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\User;
use Mail;

class ApiAuthController extends ApiController
{
    use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'verifyEmail', 'forgotPassword', 'resetPassword']]);
        $this->user = $user;
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $credentials = array('email'=>$email, 'password'=>$password);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {

            $this->user->name = $request->get('name');
            $this->user->email = $request->get('email');
            $this->user->phone = $request->get('phone');
            $this->user->address = $request->get('address');
            $this->user->id_number = $request->get('id_number');
            $this->user->password = \Illuminate\Support\Facades\Hash::make($request->get('password'));

            $this->user->save();

            $this->user->assignRole($request->get('type'));

            $data = array(
                'code' => rand(100000,999999)
            );
            Mail::send('mail', $data, function($message) {
                $message->to($this->user->email, $this->user->name)->subject('Email Verification');
            });

            $this->user->verification_token = $data['code'];
            $this->user->save();

            return $this->respond([
                    'status' => true,
                    'data' => $this->user
                ]);

        } catch (\Exception $e) {
            return $this->respond([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth()->user();
        $role = $user->roles()->pluck('name');
        $user->role = $role;
        return $this->respond($user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyEmail(Request $request)
    {
        $email = $request->get('email');
        $code = $request->get('code');

        $user = $this->user->where('email', $email)->get()->first();

        if ($user->verification_token == $code) {

            $user->verified = true;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'verified'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'verification code is not correct'
            ]);
        }
    }

    /**
     * Handle a forgot password request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        try {

            $email = $request->get('email');

            $this->user = $this->user->where('email', $email)->get()->first();
            if (!empty($this->user)) {
                $data = array(
                    'code' => rand(100000,999999)
                );
                Mail::send('mail', $data, function($message) {
                    $message->to($this->user->email, $this->user->name)->subject('Email Verification');
                });

                $this->user->verification_token = $data['code'];
                $this->user->save();

                return $this->respond([
                        'status' => true,
                        'data' => $this->user
                    ]);
            } else {
                return $this->respond([
                        'status' => false,
                        'message' => "The user don't exist"
                    ]);
            }
        } catch (\Exception $e) {
            return $this->respond([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

        /**
     * Handle a reset password request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        try {

            $email = $request->get('email');
            $code = $request->get('code');
            $password = $request->get('password');

            $user = $this->user->where('email', $email)->get()->first();

            if ($user->verification_token == $code) {

                $user->password = \Illuminate\Support\Facades\Hash::make($password);
                $user->save();

                return response()->json([
                    'status' => true,
                    'message' => 'password changed'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'invalid verification code'
                ]);
            }
        } catch (\Exception $e) {
            return $this->respond([
                'status' => false,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
