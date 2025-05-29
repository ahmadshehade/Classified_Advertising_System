<?php 

namespace  App\Interfaces\Auth;


interface AuthInterface{

    public function login($request);


    public function register($request);


    public function logout($request);


   
    
}