<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\api\Comments;
use App\Biography;
use App\OnAir;
use App\Booking;
use App\Notifications;
use App\AppLinks;

class CommentsController extends Controller
{
    public function addComment(Request $request)
    {
    	Comments::create($request->all());

    	$response = array(
    		'status' => 1,
    		'msg' => 'Comment Added.'
    	);

    	return $response;
    }

    public function list(Request $request)
    {
    	$comment = Comments::where(['song_id'=>$request->song_id])->get();

    	if(count($comment)>0)
    	{
    		$temp = array();
            foreach ($comment as $value) 
            {
                $args['comment_id'] = $value->comment_id;
                $args['user'] = "User".$value->comment_id.$value->song_id;
                $args['u_id'] = $value->u_id;
                $args['song_id'] = $value->song_id;
                $args['comment'] = $value->comment;             
                array_push($temp,$args);
            }
            $response = array(
                    'status' => 1,
                    'msg' => 'Comments for this song.',
                    'data' => $temp
                );
    	}	
    	else
    	{
    		$response = array(
    				'status' => 0,
    				'msg' => 'No comments found for this song.'
    			);
    	}

    	return $response;
    }

    public function bio()
    {
    	$bio = Biography::find(1);

    	$response = array(
    			'status' => 1,
    			'msg' => 'Biography details.',
    			'data' => $bio
    		);

    	return $response;
    }

    public function onAir()
    {
    	$onAir = OnAir::find(1);
    	if(count($onAir)>0)
    	{
    		$temp = array();

	    	$temp['onair_id'] = $onAir->onair_id;
	    	$temp['title'] = $onAir->title;
	    	$temp['link'] = $onAir->link;

	    	$response = array(
	    			'status' => 1,
	    			'msg' => 'On Air details.',
	    			'data' => $temp
	    		);
    	}
    	else
    	{
    		$response = array(
    				'status' => 0,
    				'msg' => 'No On Air Data found.'
    			);
    	}

    	return $response;
    	
    }

    public function booking(Request $request)
    {
    	Booking::create($request->all());

    	$response = array(
    			'status' => 1,
    			'msg' => 'Thank You. We will soon contact you for further details.'
    		);

    	return $response;
    }

    public function notifications()
    {
    	$notifications = Notifications::orderBy('notification_id','desc')->get();

    	if(count($notifications)>0)
    	{
    		$response = array(
    				'status' => 1,
    				'msg' => 'Notifications list.',
    				'data' => $notifications
    			);
    	}
    	else
    	{
    		$response = array(
    				'status' => 0,
    				'msg' => 'No notifications find.'
    			);
    	}

    	return $response;
    }

     public function sharelinks()
    {
        $applinks = AppLinks::find(1);

        if(count($applinks)>0)
        {
            $response = array(
                    'status' => 1,
                    'msg' => 'Share links found.',
                    'data' => $applinks
                );
        }
        else
        {   
            $response = array(
                    'status' => 0,
                    'msg' => 'No share links found.'
                );
        }
        return $response;
    }
}
