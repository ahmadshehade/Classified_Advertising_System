<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Interfaces\Category\CategoryInterface;
use Illuminate\Http\Request;

class CategoryConroller extends Controller
{
    protected $category;

    /**
     * Summary of __construct
     * @param \App\Interfaces\Category\CategoryInterface $category
     */
    public function __construct(CategoryInterface $category)
    {
        $this->category = $category;
    }
    /**
     * Summary of store
     * @param \App\Http\Requests\Category\CategoryStoreRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(CategoryStoreRequest $request)
    {
        $data = $this->category->store($request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
    /**
     * Summary of update
     * @param mixed $id
     * @param \App\Http\Requests\Category\CategoryUpdateRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update($id, CategoryUpdateRequest $request)
    {
        $data = $this->category->update($id, $request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
    /**
     * Summary of destroy
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = $this->category->destroy($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
    /**
     * Summary of show
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->category->show($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->category->index();
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
}
