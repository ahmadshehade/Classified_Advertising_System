<?php 

namespace App\Interfaces\User;

interface UserInterface{

    public function index();


    public function show($id);


    public function destroy($id);


    public function update($id,$request);
}