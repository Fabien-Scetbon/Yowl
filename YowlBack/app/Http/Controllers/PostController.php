<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PostController extends BaseController
{
    public function getPostsPage()
    {
        $posts = Post::orderBy('id','DESC')->paginate(5);

        foreach ($posts as $post) {
            $user = User::findOrFail($post->user_id);
            $post['login'] = $user->login;

            $category = Category::findOrFail($post->category_id);
            $post['category'] = $category->name;

            $nbComments = Comment::where('post_id', '=', $post->id)->count();
            $post['nbComments'] = $nbComments;

        };

        $message = 'Request Get Topic index successfull.';

        return $this->sendResponse([
            'posts' => $posts,
        ], $message, 201);
    }
    public function getPosts()
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            $user = User::findOrFail($post->user_id);
            $post['login'] = $user->login;

            $category = Category::findOrFail($post->category_id);
            $post['category'] = $category->name;

            $nbComments = Comment::where('post_id','=',$post->id)->count();
            $post['nbComments'] = $nbComments;

        };

        $message = 'Request Get Post index successfull.';

        return $this->sendResponse([
            'posts' => $posts,

        ], $message, 201);
    }

    public function getPost($id)
    {
        try {
            $post = Post::findOrFail($id);

            $user = User::findOrFail($post->user_id);
            $post['login'] = $user->login;

            $category = Category::findOrFail($post->category_id);
            $post['category'] = $category->name;

            $nbComments = Comment::where('post_id', '=', $post->id)->count();
            $post['nbComments'] = $nbComments;
            
        } catch (ModelNotFoundException $e) {
            return $this->sendError('Post not found', $e, 400);
        }

        $message = 'Post successfully found';
        return $this->sendResponse([
            'post' => $post,
        ], $message, 201);
    }

    public function createPost(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'user_id'=> 'required',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $post = Post::create($data);

        $message = "Post created !";

        return $this->sendResponse($post, $message, 201);
    }

    public function updatePost(Request $request, $id)
    {
        $post = Post::find($id);
        $data = $request->all();

        $validator = Validator::make($data, [

            'title' => 'sometimes',
            'content' => 'sometimes',
            'category_id' => 'sometimes',
            'user_id' => 'sometimes',
            'url' => 'sometimes|url',
            'likes_number' => 'sometimes',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        if (isset($data['title'])) {
            $post->title = $data['title'];}
        if (isset($data['content'])) {
            $post->content = $data['content']; }
        if (isset($data['category_id'])) {
            $post->category_id = $data['category_id'];}
        if (isset($data['user_id'])) {
            $post->user_id = $data['user_id'];}
        if (isset($data['url'])) {    
            $post->url = $data['url'];}
        if (isset($data['likes_number'])) {    
            $post->likes_number = $data['likes_number'];}

        $result = $post->save();

        if ($result) {
            $message = 'The Post has been succesfully updated';
        } else {
            $message = 'We have encounter an error in the updating of the Post';
        }

        return $this->sendResponse($post, $message, 201);
    }

    public function deletePost($id)
    {
        $post = Post::find($id);
        $result = $post->delete();
        if ($result) {
            $message = 'The Post has been succesfully delete';
        } else {
            $message = 'We have encounter an error in the deleting of the Post';
        }
        return $this->sendResponse($post, $message, 201);
    }

}
