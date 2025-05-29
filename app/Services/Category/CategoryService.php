<?php

namespace App\Services\Category;

use App\Interfaces\Category\CategoryInterface;
use App\Models\Category;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Gate;

class CategoryService implements CategoryInterface
{
    use AuthorizesRequests;

    /**
     * Summary of index
     * @return array{code: int, data: \Illuminate\Database\Eloquent\Collection<int, Category>, message: string}
     */
    public function index() {
           $this->authorize('viewAny',Category::class);
        $categories=Category::orderBy('id','desc')->get();
     
        $data=[
            'message'=>'Successfully  get All Categories',
            'data'=>$categories,
            'code'=>200
        ];
        return $data;

    }

    /**
     * Summary of store
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Category, message: string}
     */
    public function store($request)
    {
        try {
            $validate = $request->validated();
            $this->authorize('create', Category::class);
            $category = Category::create($validate);
            $data = [
                'message' => 'Successfully  Create Category ',
                'data' => $category,
                'code' => 201
            ];
            return $data;
        } catch (Exception $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => ' Server error: ' . $e->getMessage(),
                ], 500)
            );
        }
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Category|\Illuminate\Database\Eloquent\Collection<int, Category>, message: string}
     */
    public function update($id, $request)
    {
        try {
            $validate = $request->validated();

            $category = Category::find($id);
            if (!$category) {
                throw new HttpResponseException(
                    response()->json([
                        'message' => 'Category not Found'
                    ], 404)
                );
            }
             $this->authorize('update', $category);
             $category->update($validate);
             $data=[
                'message'=>'Successfully Update Category',
                'data'=>$category,
                'code'=>200
             ];
             return $data;
        } catch (Exception $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => ' Server error: ' . $e->getMessage(),
                ], 500)
            );
        }
    }

    /**
     * Summary of destroy
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: bool, message: string}
     */
    public function destroy($id) {
            $category = Category::find($id);
            if (!$category) {
                throw new HttpResponseException(
                    response()->json([
                        'message' => 'Category not Found'
                    ], 404)
                );
            }
            $this->authorize('delete',$category);
            $category->delete();
            $data=[
                'message'=>'Successfully  delete Category',
                'data'=>true,
                'code'=>200
            ];
            return $data;
    }

    /**
     * Summary of show
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: Category|\Illuminate\Database\Eloquent\Collection<int, Category>, message: string}
     */
    public function show($id) {
                   $category = Category::find($id);
            if (!$category) {
                throw new HttpResponseException(
                    response()->json([
                        'message' => 'Category not Found'
                    ], 404)
                );
            }
            $this->authorize('view',$category);
            $data=[
                'message'=>'Successfully Get Category',
                'data'=>$category,
                'code'=>200
            ];
            return $data;
    }
}
