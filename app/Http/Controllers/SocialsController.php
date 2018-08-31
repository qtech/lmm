<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Social;
use Validator;

class SocialsController extends Controller
{
    public function index()
    {
    	$socials = Social::all();

    	return view('socials.main')->with('socials',$socials);
    }

    public function edit($id)
    {
    	$social = Social::find($id);
    	 return view('socials.edit')->with('social',$social);
    }

    public function update(Request $request, $id)
    {
    	$validator = Validator::make($request->all(),[
    			'social_name' => 'required|string|max:100',
    			'social_link' => 'required|url|max:255'
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('socials.edit',['id'=>$id])->withErrors($validator);
    	}
    	else
    	{
    		$social = Social::find($id);
    		$social->social_name = $request->social_name;
    		$social->social_link = $request->social_link;
    		$social->save();

    		return redirect()->route('socials.edit',['id'=>$id])->with('success','Social Link information successfully updated');
    	}
    }
}
