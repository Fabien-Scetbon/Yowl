<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{  

    public function getUsers()
    {
        
        $users = User::all();
        $message = 'Request Get User index successfull.';

        return $this->sendResponse([
            'users' => $users,
           
        ], $message, 201);
    }
   
    public function getUser($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->sendError('User not found', $e, 400);
        }

        $message = 'User successfully found';
        return $this->sendResponse([
            'user' => $user,
        ], $message, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();
/*
        $login_exists = User::where('id', '!=', $id)->where('login', $data['login'])->first();
        if (isset($login_exists)) {
            $message = 'The Login already exists';
            return $this->sendError($message, 400);
        }
      
        $email_exists = User::where('id', '!=', $id)->where('email', $data['email'])->first();
        if (isset($email_exists)) {
            $message = 'The Email already exists';
            return $this->sendError($message, 400);
        }
        */
        $validator = Validator::make($data, [

            'login' => 'sometimes',
            'email' => 'sometimes|email',
            'status' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        if (isset($data['login'])) {
            $user->login = $data['login']; }

        if (isset($data['email'])) {
                $user->email = $data['email'];}
        if (isset($data['status'])) {
                    $user->status = $data['status'];}


        $result = $user->save();

        if ($result) {
            $message = 'The User has been succesfully updated';
        } else {
            $message = 'We have encounter an error in the updating of the User';
        }

        return $this->sendResponse($user, $message, 201);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $result = $user->delete();
        if ($result) {
            $message = 'The User has been succesfully delete';
        } else {
            $message = 'We have encounter an error in the deleting of the User';
        }
        return $this->sendResponse($user, $message, 201);
    }
}