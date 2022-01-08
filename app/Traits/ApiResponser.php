<?php
namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    //function to return success response in JSON
    private function successResponse($data,$code){
        return response()->json($data,$code);
    }
    //function to return a collection of data
    protected function showAll(Collection $collection,$code = 200){
        if ( $collection->isEmpty()){
            return $this->successResponse(['data'=>$collection],$code);
        }
        return $this->successResponse($collection,$code);
    }
    protected function showOne(Model $instance, $code = 200) {
        return $this->successResponse($instance,$code);
    }
}