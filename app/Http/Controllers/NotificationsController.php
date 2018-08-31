<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications;
use Validator;
class NotificationsController extends Controller
{
    public function index()
    {
    	$notifications = Notifications::orderBy('notification_id','desc')->paginate(10);
    	return view('notifications.main')->with('notifications', $notifications);
    }

    public function send()
    {
    	return view('notifications.send');
    }

    public function store(Request $request)
    {
    	$validator = Validator::make($request->all(),['message'=>'required|string|max:255']);
    	if($validator->fails()) 
    	{ 
    		return redirect()->route('notifications.send')->withErrors($validator)->withInput([
    			'message'=>$request->message
    		]); 
    	}
    	else
    	{
    			$message = $request->message;

                $url = 'https://fcm.googleapis.com/fcm/send';
                // $server_key = "AIzaSyBeQVoPjkDnvpMM8xZTG6cYUv3N6jKDOrY";

                $fields = '{
                "to": "/topics/dj_andujar",
                "data": {
                        "body": "'.$message.'",
    					"notiType":"0"
                    },
                "notification": {
                        "body": "'.$message.'",
    					"notiType":"1"
                    }
                }';

                $headers = array(
                    'Authorization: key=' . $server_key,
                    'Content-Type: application/json'
                );
                // Open connection
                $ch = curl_init();
                //print_r(json_encode($fields)); exit;
                // Set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
         
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         
                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                
                // Execute post
                $result = curl_exec($ch);
                curl_close($ch);

                $notification = new Notifications;
                $notification->message = $request->message;
                $notification->save();

                return redirect()->route('notifications.send')->with('success','Notifications to all user successfully send.');
                
    	}

    }

    public function destroy($id)
    {
    	$notification = Notifications::find($id);
    	$notification->delete();

    	return redirect()->route('notifications.index')->with('success','Notification information successfully removed.');
    }
}
