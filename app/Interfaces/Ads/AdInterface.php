<?php 

namespace App\Interfaces\Ads;

interface AdInterface{

    public function index();

    public function store($request);

    public function show($id);

    public function update($id,$request);


    public function destroy($id);

    public function filter(array $filters);

}