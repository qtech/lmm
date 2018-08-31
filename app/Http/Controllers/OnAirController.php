<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OnAir;
use Validator;
class OnAirController extends Controller
{
    public function index()
    {
    	$onair = OnAir::find(1);

    	return view('onair.main')->with('onair',$onair);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    			'title' => 'required|string|max:50',
    			'link' => 'required|url|max:255'
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('onair.index')->withErrors($validator);
    	}
    	else
    	{
    		$link = $request->link;
    		$link_pos = strrpos($link, ".mp3");
    		$link = substr($link, $link_pos, strlen($link));
    		
    		if($link == ".mp3")
    		{
    			$onair = OnAir::find($id);
    			$onair->title = $request->title;
    			$onair->link = $request->link;
    			$onair->save();

    			return redirect()->route('onair.index')->with('success','On Air information successfully updated.');
    		}
    		else
    		{
    			return redirect()->route('onair.index')->with('error','You have entered an invalid url. Please make sure the "On Air Link" links to the mp3 file.');
    		}
    	}
    }
}
