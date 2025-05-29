<?php 

namespace App\Interfaces\Ads;

interface AdsInterface{

    public function index();

    public function store($request);

    public function show($id);

    public function update($id,$request);


    public function destroy($id);

    public function filter(array $filters);

}