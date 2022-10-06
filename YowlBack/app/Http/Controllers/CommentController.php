<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\BaseController as BaseController;

class CommentController extends BaseController
{
    public function getComments()
    {
        $comments = Comment::all();

        foreach ($comments as $comment) {
            $user = User::findOrFail($comment->user_id);
            $comment['login'] = $user->login;

            $post = Post::findOrFail($comment->post_id);
            $comment['post_title'] = $post->title;
        };


        $message = 'Request Get Post index successfull.';

        return $this->sendResponse([
            'comments' => $comments,

        ], $message, 201);
    }

    public function getComment($id)
    {
        $comment = Comment::findOrFail($id);
        $user = User::findOrFail($comment->user_id);
        $comment['login'] = $user->login;
        $post = Post::findOrFail($comment->post_id);
        $comment['post_title'] = $post->title;

        if ($comment) {
            $message = 'Comment successfully found';
            return $this->sendResponse([
                'comment' => $comment,
            ], $message, 200);
        } else {
            return $this->sendError('Comment not found', 404);
        }
    }

    public function createComment(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'post_id' => 'required',
            'user_id' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $comment = Comment::create($data);

        $message = "Comment created !";

        return $this->sendResponse($comment, $message, 201);
    }

    public function updateComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        $data = $request->all();

        $validator = Validator::make($data, [

            'post_id' => 'required',
            'user_id' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        $comment->post_id = $data['post_id'];
        $comment->user_id = $data['user_id'];
        $comment->content = $data['content'];
        $result = $comment->save();

        if ($result) {
            $message = 'The Comment has been succesfully updated';
        } else {
            $message = 'We have encounter an error in the updating of the Comment';
        }

        return $this->sendResponse($comment, $message, 201);
    }

    public function deleteComment($id)
    {
        $comment = Comment::find($id);
        $result = $comment->delete();
        if ($result) {
            $message = 'The Comment has been succesfully delete';
        } else {
            $message = 'We have encounter an error in the deleting of the Comment';
        }
        return $this->sendResponse($comment, $message, 201);
    }
}
