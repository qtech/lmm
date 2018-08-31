<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ArtistBio;

class ArtistBioController extends Controller
{
    public function getAll()
    {
    	$artists_bio = ArtistBio::with('artists')->orderBy('bio_id','desc')->get();
    	if(count($artists_bio)>0)
    	{
    		$temp = array();
    		foreach ($artists_bio as $value) 
    		{
    			$args['bio_id'] = $value->bio_id;
                $args['artist_id'] = $value->album_id;
    			$args['artist_name'] = @$value->artists->album_name;
    			$args['biography'] = "<body style='background:#19181B;color:white'>".$value->biography."</body>";
                $args['insta_url'] = $value->insta_url;
    			$args['thumb'] = url('/').'/storage/uploads/'.$value->thumb;
    			$args['banner'] = url('/').'/storage/uploads/'.$value->banner;
    			array_push($temp, $args);
    		}

    		$response = array(
    			'status' => 1,
    			'msg' => 'List of Artist Biographies.',
    			'data' => $temp
    		);
    	}
    	else
    	{
    		$response = array(
    			'stauts' => 0,
    			'msg' => 'No artists biographies found.'
    		);
    	}

    	return $response;
    }

    public function getSingleBiography(Request $request)
    {
    	if($request->has('bio_id'))
    	{
    		$artist_bio = ArtistBio::find($request->bio_id);
    		if(count($artist_bio)>0)
    		{
                $args['bio_id'] = $artist_bio->bio_id;
                $args['artist_name'] = $artist_bio->artist_name;
                $args['biography'] = $artist_bio->biography;
                $args['insta_url'] = $artist_bio->insta_url;
                $args['thumb'] = url('/').'/storage/uploads/'.$artist_bio->thumb;
                $args['banner'] = url('/').'/storage/uploads/'.$artist_bio->banner;

                $response = array(
                    'status' => 1,
                    'msg' => 'Artist with Biography',
                    'data' => $args
                );
    		}
    		else
    		{
    			$response = array(
	    			'status' => 0,
	    			'msg' => 'Invalid Arguments given.'
	    		);		
    		}
    	}
    	else
    	{
    		$response = array(
    			'status' => 0,
    			'msg' => 'Invalid Arguments given.'
    		);
    	}
        return $response;
    }
}
