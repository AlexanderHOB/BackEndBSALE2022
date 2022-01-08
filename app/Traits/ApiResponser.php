<?php
namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;
trait ApiResponser
{
    //function to return success response in JSON
    private function successResponse($data,$code){
        return response()->json($data,$code);
    }
    //function to return error in Json format
    protected function errorResponse($message,$code)
    {
        return response()->json(['error'=>$message,'code'=>$code],$code);
    }
    //function to return a collection of data
    protected function showAll(Collection $collection,$code = 200){
        if ( $collection->isEmpty()){
            return $this->successResponse(['data'=>$collection],$code);
        }
        $collection = $this->filterData($collection);
        $collection = $this->sortData($collection);
        $collection = $this->paginate($collection);
        return $this->successResponse($collection,$code);
    }
    //function to return a One Resource
    protected function showOne(Model $instance, $code = 200) {
        return $this->successResponse($instance,$code);
    }
    //function to filterData by querys
    protected function filterData(Collection $collection){
        foreach(request()->query as $query =>$value){
            if(isset($query,$value) && !in_array($query, ['sort_by','sort','per_page','page'])){
                $collection = $collection->filter(function ($query) use ($value) {
                    return strpos($query->name, $value) !== false;
                });
            }
        }
        return $collection;
    }
    //function to sort data by attribute
    protected function sortData(Collection $collection){
        // validate that request has sort by attribute
        if(request()->has('sort_by')){
            $attribute = request()->sort_by;
            $collection = $collection->sortBy->{$attribute};

            //validate if the request has a sort order by attribute
            if(request()->has('sort') &&  in_array(request()->has('sort'),['asc','desc'])){
                $order = request()->sort;
                $collection = ($order === 'desc') 
                                ? $collection->sortByDesc->{$attribute}
                                : $collection->sortBy->{$attribute};
            }
        }
        return $collection;
    }
    // function to paginate data by quantity
    protected function paginate(Collection $collection){
        $rules = [
            'per_page' => 'integer|min:2|max:50'
        ];
        Validator::Validate(request()->all(),$rules);
        //resolve current page
        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage=15; //quantity  elements default

        if(request()->has('per_page')){
            $perPage = (int) request()->per_page;
        }

        $results = $collection->slice(($page-1)*$perPage,$perPage)->values();

        $paginated = new LengthAwarePaginator($results,$collection->count(),$perPage,$page,[
            'path'=>LengthAwarePaginator::resolveCurrentPath()
            ]);
        $paginated->appends(request()->all());

        return $paginated;
    }
}