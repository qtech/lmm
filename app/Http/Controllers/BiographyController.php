<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biography;
use Validator;
class BiographyController extends Controller
{
    public function index()
    {
    	$biography = Biography::find(1);
    	return view('biography.main')->with('biography',$biography);
    }

    public function update(Request $request,$id)
    {
    	$validator = Validator::make($request->all(),[
    			'title' => 'required|string|max:255',
    			'text' => 'required'
    		]);

    	if($validator->fails())
    	{
    		return redirect()->route('bio.index')->withErrors($validator);
    	}
    	else
    	{
    		$bio = Biography::find($id);
    		$bio->title = $request->title;
    		$bio->text = $request->text;
    		$bio->save();

    		return redirect()->route('bio.index')->with('success','Biography information successfully updated.');
    	}
    }
}
