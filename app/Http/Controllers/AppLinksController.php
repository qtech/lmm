<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppLinks;
use Validator;
class AppLinksController extends Controller
{
    public function index()
    {
    	$share = AppLinks::find(1);
    	return view('applinks.main')->with('share',$share);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    		'android_link' => 'required|url|max:255',
    		'ios_link' => 'required|url|max:255',
    		'text' => 'required|string|max:255'
    	]);

    	if($validator->fails())
    	{
    		return redirect()->route('shares.index')->withErrors($validator);
    	}
    	else
    	{
    		$applinks = AppLinks::find($id);
    		$applinks->android_link = $request->android_link;
    		$applinks->ios_link = $request->ios_link;
    		$applinks->text = $request->text;
    		$applinks->save();

    		return redirect()->route('shares.index')->with('success','App Share Links successfully updated.');
    	}
    }
}
