<?php
namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data,$code);
    }
    protected function errorResponse($message,$code)
    {
        return response()->json(['error'=> $message, 'code'=>$code],$code);
    }
    protected function showAll(Collection $collection,$code=200)
    {
        return $this->successResponse(['data'=>$collection], $code);
        // $collection ->$this ->sortData($collection);
    }
    protected function showOne(Model $model,$code=200)
    {
        return $this->successResponse(['data'=>$model], $code);
    }
    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data'=> $message], $code);
    }
    // protected function SortData(Collection $collection)
    // {
    //     if (request() ->has('sort_by')) {
    //         $attribute = request()->sort_by;
    //         $collection= $collection->sortBy->{$attribute}
    //     }
    //     return $collection;
    // }
}