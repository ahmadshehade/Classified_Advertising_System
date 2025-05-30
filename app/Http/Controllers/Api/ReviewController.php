<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Review\ReviewStoreRequest;
use App\Http\Requests\Review\ReviewUpdateRequest;
use App\Interfaces\Reviews\ReviewInterface;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    protected $var;

    /**
     * Summary of __construct
     * @param \App\Interfaces\Reviews\ReviewInterface $review
     */
    public function __construct(ReviewInterface $review)
    {
        $this->var = $review;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->var->index();
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewStoreRequest $request)
    {
        $data = $this->var->store($request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = $this->var->show($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, ReviewUpdateRequest $request)
    {
        $data = $this->var->update($id, $request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = $this->var->destroy($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
}
