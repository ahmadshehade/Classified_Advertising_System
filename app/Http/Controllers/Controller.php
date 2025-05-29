<?php

namespace App\Http\Controllers;

abstract class Controller
{
    
    /**
     * Summary of formMesage
     * @param mixed $message
     * @param mixed $data
     * @param mixed $code
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function formMesage($message,$data,$code){
        return response()->json(
            [
                'message'=>$message,
                'data'=>$data
            ],$code
        );
    }
}
