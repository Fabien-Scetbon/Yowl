<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class LikeController extends BaseController
{
    
    public function getLikes()
    {
        $likes = Like::all();

        foreach ($likes as $like) {
            $user = User::findOrFail($like->user_id);
            $like['user_id'] = $user->id;

            $post = Post::findOrFail($like->post_id);
            $like['post_id'] = $post->id;
        };


        $message = 'Request Get like index successfull.';

        return $this->sendResponse([
            'likes' => $likes,

        ], $message, 201);
    }

    public function getLikeById($id)
    {
        $like = Like::findOrFail($id);
        $user = User::findOrFail($like->user_id);
        $like['user_id'] = $user->id;
        $post = Post::findOrFail($like->post_id);
        $like['post_id'] = $post->id;

        if ($like) {
            $message = 'Like successfully found';
            return $this->sendResponse([
                'like' => $like,
            ], $message, 200);
        } else {
            return $this->sendError('Like not found', 404);
        }
    }
    
    public function getLikeByUser($user_id)
    {
        $like = Like::findOrFail($user_id);
        $user = User::findOrFail($like->user_id);
        $like['user_id'] = $user->id;
        $post = Post::findOrFail($like->post_id);
        $like['post_id'] = $post->id;

        if ($like) {
            $message = 'Like successfully found';
            return $this->sendResponse([
                'like' => $like,
            ], $message, 200);
        } else {
            return $this->sendError('Like not found', 404);
        }
    }

    public function getLikeByPost($post_id)
    {
        $like = Like::findOrFail($post_id);
        $user = User::findOrFail($like->user_id);
        $like['user_id'] = $user->id;
        $post = Post::findOrFail($like->post_id);
        $like['post_id'] = $post->id;

        if ($like) {
            $message = 'Like successfully found';
            return $this->sendResponse([
                'like' => $like,
            ], $message, 200);
        } else {
            return $this->sendError('Like not found', 404);
        }
    }

    public function createLike(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'post_id' => 'required',
            'user_id' => 'required',
            'liked' => 'required|boolean',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $like = Like::create($data);

        $message = "like created !";

        return $this->sendResponse($like, $message, 201);
    }

    public function updateLike(Request $request, $id)
    {
        $like = Like::find($id);
        $data = $request->all();

        $validator = Validator::make($data, [

            'post_id' => 'required',
            'user_id' => 'required',
            'liked' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        $like->post_id = $data['post_id'];
        $like->user_id = $data['user_id'];
        $like->liked = $data['liked'];
        $result = $like->save();

        if ($result) {
            $message = 'The like has been succesfully updated';
        } else {
            $message = 'We have encounter an error in the updating of the like';
        }

        return $this->sendResponse($like, $message, 201);
    }

    
    public function deleteLike($id)
    {
        $like = Like::find($id);
        $result = $like->delete();
        if ($result) {
            $message = 'The like has been succesfully delete';
        } else {
            $message = 'We have encounter an error in the deleting of the like';
        }
        return $this->sendResponse($like, $message, 201);
    }
}
