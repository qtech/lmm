<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Products;
use Validator;
use Storage;
use App\ImageUpload;

class ProductsController extends Controller
{
    public function getProducts()
    {
        try
        {
            $products = Products::all();
            $data = [];
    
            if($products)
            {
                foreach($products as $value)
                {
                    $tmp = [
                        'product_name' => $value->product_name,
                        'product_price' => '$'.$value->product_price,
                        'product_image' => url('/')."/storage/uploads/".$value->product_image
                    ];
    
                    array_push($data,$tmp);
                }
    
                $response = [
                    'msg' => 'Available DJ Products',
                    'status' => 1,
                    'data' => $data
                ];
            }
        }
        catch(\Exception $e)
        {
            $response = [
                'msg' => $e->getMessage()." ".$e->getFile()." ".$e->getLine(),
                'status' => 0
            ];
        }
    
        return response()->json($response);
    }   
}   
