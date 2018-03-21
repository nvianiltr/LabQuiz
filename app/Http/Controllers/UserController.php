<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Validator;

class UserController extends Controller
{	
	protected $user;

	public function __construct(User $user) {
		$this->user = $user;
	}

	/* STORE A USER */
    public function store(Request $request) {
    	$user = [
    		"name"		=> $request->name,
    		"email"		=> $request->email,
    		"password" 	=> md5($request->password)
    	];

        try { 
            $user = $this->user->create($user); 
            return response('Created',201);
        } 
        catch(Exception $ex) { 
            return response('Failed', 400);
        }
    }

    /* SHOW ALL USERS AND ITEMS THAT THEY HAVE */
    public function show() {
    	try {
            $users = $this->user->with('items')->get();
            return response()->json($users, 200);
        }
        catch (Exception $ex) {
        	echo $ex;
            return response('Failed', 400);
        }
    }

    /* UPDATE USER'S INFORMATION DETAILS */
    public function update($id, Request $request) {
    	try {
	    	/* WHY USE VALIDATOR? BECAUSE USER CAN INSERT EMAIL WITHOUT @ AND . SYMBOL IF WE DON'T USE VALIDATOR SINCE DATA TYPE FOR EMAIL IN DATABASE IS STRING */
	    	$validator = Validator::make($request->all(), [
	            "name" 		=> 'required|string|min:3|max:191',
	            "email" 	=> 'required|email|max:191',
	            "password" 	=> 'required|string|min:6|max:191',
	    	]);

	        if ($validator->fails()) {
	        	$message = ["message" => $validator->errors()->all()];
	        	throw new \Illuminate\Validation\ValidationException($message,400);
	        }

	        else {
				$user = $this->user->find($id)->update([
		            "name" 		=> $request->name,
		            "email" 	=> $request->email,
		            "password"	=> md5($request->password)    
	        	]);

	       		return response('Updated', 200);
        	}
        }
        catch(Exception $ex) {
        	return response()->json($ex, 400);
        }
    }

    /* ITEMS WHERE ITEMS.USER_ID = USERS.ID WILL ALSO BE DELETED BECAUSE ON DELETE = CASCADE */
    public function delete($id) {
    	try {
    		$this->user->find($id)->delete();
    		return response('Deleted', 200);
    	}
    	catch (Exception $ex) {
    		return response($ex, 400);
    	}
    }
}
