<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Buyer;
use App\Product;
use Illuminate\Http\Request;

class ProductBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $buyer = $product -> transactions()
            ->with('buyer')
            ->get()
            ->plucK('buyer')
            ->unique('id')
            ->values();
        return $this -> showAll($buyer);
    }

    
}
