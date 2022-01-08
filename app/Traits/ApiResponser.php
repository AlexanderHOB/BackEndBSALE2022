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
        $collection = $this->filterData($collection);
        return $this->successResponse($collection,$code);
    }
    //function to return a One Resource
    protected function showOne(Model $instance, $code = 200) {
        return $this->successResponse($instance,$code);
    }
    //function to filterData by querys
    protected function filterData(Collection $collection){
        foreach(request()->query as $query =>$value){
            if(isset($query,$value)){
                $collection = $collection->filter(function ($query) use ($value) {
                    return strpos($query->name, $value) !== false;
                });
            }
        }

        return $collection;
    }

}