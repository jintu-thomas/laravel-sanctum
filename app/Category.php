<?php

namespace App;
use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class Category extends Model
{
    //
    use softDeletes;
    protected $dates =['delet_at'];

    protected $fillable = [

        'name',
        'description',
    ];
    protected $hidden =[
        'pivot'
    ];
    public function products()
    {
        return $this ->belongsToMany(Product::class);
    }
}
