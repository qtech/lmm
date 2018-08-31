<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;
use Validator;
use Storage;
use App\ImageUpload;

class ProductsController extends Controller
{
    public function index()
    {
    	$products = Products::orderBy('product_id','desc')->paginate(10);
    	return view('djproducts.main')->with('products',$products);
    }

    public function add()
    {
    	return view('djproducts.add');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    			'product_name' => 'required|string|max:50',
                'product_image' => 'required|image',
                'product_price' => 'required'
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('djproducts.add')->withErrors($validator)->withInput(['product_name'=>$request->product_name]);
    	}
    	else
    	{
    		if($request->hasFile('product_image'))
    		{
    			$fileNameToStore = ImageUpload::uploadImage($request,'product_image');
    		}

    		$product = new Products;
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
    		$product->product_image = $fileNameToStore;
    		$product->save();

    		return redirect()->route('djproducts.index')->with('success','DJ Product Successfully Added.');
    	}
    }

    public function edit($id)
    {
    	$product = Products::find($id);
    	return view('djproducts.edit')->with('product',$product);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'product_name' => 'required|string|max:50',
            'product_image' => 'nullable|image',
            'product_price' => 'required'
            ]);

        if($validator->fails())
        {
            return redirect()->route('djproducts.edit',['id'=>$id])->withErrors($validator)->withInput(['product_name'=>$request->product_name]);
        }
        else
        {
            if($request->hasFile('product_image'))
            {
                $fileNameToStore = ImageUpload::uploadImage($request,'product_image');
            }            

            $product = Products::find($id);
            $product->product_name = $request->product_name;
            $product->product_price = $request->product_price;
    		
            if($request->hasFile('product_image'))
            {
                Storage::delete(getenv('IMG_UPLOAD').$product->product_image);
                $product->product_image = $fileNameToStore;
            }
            $product->save();

            return redirect()->route('djproducts.index')->with('success','DJ Product Information Successfully Updated.');
        }
    }

    public function destroy($id)
    {
        $product = Products::find($id);
        if($product->product_image != NULL)
        {
            Storage::delete(getenv('IMG_UPLOAD').$product->product_image);            
        }

        $product->delete();

        return redirect()->route('djproducts.index')->with('success','DJ Product Successfully Removed.');
    }
}
