<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\api\Likes;
class LikesController extends Controller
{
    public function addlike(Request $request)
    {
    	$checkRecords = Likes::where(['u_id' => $request->u_id, 'song_id' => $request->song_id ])->first();
    	if(count($checkRecords)>0)
    	{
    		if($checkRecords->like_status==1)
    		{
    			$checkRecords->like_status = 0;	
    		}
    		else
    		{
    			$checkRecords->like_status = 1;	
    		}    		
    		$checkRecords->save();

            $getLikeStatusNow = Likes::where(['u_id' => $request->u_id, 'song_id' => $request->song_id ])->first();
    	}
    	else
    	{
    		$newLike = new Likes;
    		$newLike->u_id = $request->u_id;
    		$newLike->song_id = $request->song_id;
    		$newLike->like_status = 1;
    		$newLike->save();

            $getLikeStatusNow = Likes::find($newLike->like_id);
    	}

        $temp['u_id'] = $getLikeStatusNow->u_id;
        $temp['song_id'] = $getLikeStatusNow->song_id;
        $temp['like_status'] = $getLikeStatusNow->like_status;
        $temp['total_like'] = Likes::where(['song_id'=>$request->song_id,'like_status' => 1])->count();

    	$response = array(
			'status' => 1,
			'msg' => "Success",  
            'data' => $temp  

		);

    	return $response;
    }
}
