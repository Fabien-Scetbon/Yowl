<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PassportAuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)

    {
        $data = $request->all();

        $validator = Validator::make($data, [

            'login' => 'required|unique:users',

            'email' => 'required|email|unique:users',

            'password' => 'required|confirmed',

            'status' => 'sometimes|boolean',

        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);

        $user['token'] =  $user->createToken('MyApp')->accessToken;

        $message = "SUBSCRIPTION CONFIRMED !";

        //dd($user);

        return $this->sendResponse($user, $message, 201);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request)

    {
        $validator = Validator::make($request->all(), [

            'login' => 'required|exists:users',

            'password' => 'required',

        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors(), 400);       

        }

        if(!Auth::attempt(['login' => $request->login, 'password' => $request->password])){

            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised'], 401);

        }

        $user = Auth::user();

        $user['token'] =  $user->createToken('MyApp')->accessToken; // erreur mais fonctionne quand meme (donc fausse erreur)

        $message = 'User login successfully.';

        return $this->sendResponse($user, $message, 200);
    }

    /**
     * Logout api
     *
     * @return \Illuminate\Http\Response
     */

    public function logout(Request $request)

    {
        $user = Auth::check();
        return $user;
    }
}
