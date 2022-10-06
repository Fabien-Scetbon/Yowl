<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Category;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{

    public function getCategories()
    {
        $categories = Category::all();

        $message = 'Request Get Categories successfull.';

        return $this->sendResponse([
            'categories' => $categories,

        ], $message, 201);
    }

    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
       
        if ($category) {
            $message = 'Category successfully found';
            return $this->sendResponse([
                'category' => $category,
            ], $message, 200);
        } else {
            return $this->sendError('Category not found', 404);
        }
    }

    public function createCategory(Request $request)

    {
        $data = $request->all(); 

        $validator = Validator::make($data, [
            'name' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $category = Category::create($data);

        $message = "Category created !";

        return $this->sendResponse($category, $message, 201);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $data = $request->all();

        $validator = Validator::make($data, [

            'name' => 'required',

        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $category->name = $data['name'];
        $result = $category->save();

        if ($result) {
            $message = 'The Category has been succesfully updated';
        } else {
            $message = 'We have encounter an error in the updating of the Category';
        }

        return $this->sendResponse($category, $message, 201);
    }

    public function delete($id)
    {
        $category = Category::find($id);
        $result = $category->delete();
        if ($result) {
            $message = 'The Category has been succesfully delete';
        } else {
            $message = 'We have encounter an error in the deleting of the Category';
        }
        return $this->sendResponse($category, $message, 201);
    }
}
