<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\api\NewUser;
class NewUsersController extends Controller
{
    public function add_user(Request $request)
    {
        $checkUser = NewUser::where(['u_id'=>$request->u_id])->first();
        
        if(count($checkUser)>0)
        {
            $response = array(
                    'status' => 1,
                    'msg'    => 'User already registered',
                    'data'   => array(
                            'u_id' => $request->u_id,
                        )
                );
        }
        else
        {
            $newuser = new NewUser;
            $newuser->u_id = $request->u_id;
            $newuser->gcm_id = $request->gcm_id;
            $newuser->device = $request->device;
            $newuser->save();

            $getNewUserId = $newuser->user_id;

            $getUID = NewUser::find($getNewUserId);

            $response = array(
                    'status' => 1,
                    'msg'    => 'User registered',
                    'data'   => array(
                            'u_id' => $getUID->u_id,
                        )
                );
        }       
        return $response;
    }
}
