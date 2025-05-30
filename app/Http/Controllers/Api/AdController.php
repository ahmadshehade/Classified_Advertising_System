<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ads\AdsStoreRequest;
use App\Http\Requests\Ads\AdsUpdateRequest;
use App\Interfaces\Ads\AdInterface;
use Illuminate\Http\Request;

class AdController extends Controller
{
    protected  $ads;

    /**
     * Summary of __construct
     * @param \App\Interfaces\Ads\AdInterface $ads
     */
    public function __construct(AdInterface  $ads)
    {
        $this->ads = $ads;
    }


    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->ads->index();
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\Ads\AdsStoreRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function store(AdsStoreRequest $request)
    {
        $data = $this->ads->store($request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
    /**
     * Summary of show
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->ads->show($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }



    /**
     * Summary of update
     * @param mixed $id
     * @param \App\Http\Requests\Ads\AdsUpdateRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update($id, AdsUpdateRequest $request)
    {
        $data = $this->ads->update($id, $request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
    /**
     * Summary of destroy
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = $this->ads->destroy($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }


    /**
     * Summary of filter
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $filters = $request->only(['user_id', 'category_id']); 
        $data = $this->ads->filter($filters);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
}
