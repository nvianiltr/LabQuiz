<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Item;
use Exception;

class ItemController extends Controller
{
    protected $item;

	public function __construct(Item $item) {
		$this->item = $item;
	}

	/* STORE AN ITEM */
    public function store(Request $request) {
    	$item = [
    		"user_id"	=> $request->user_id,
    		"price"		=> $request->price,
    		"name"		=> $request->name,
    		"stock" 	=> $request->stock    	
    	];

        try 
        { 
            $item = $this->item->create($item); 
            return response('Created',201);
        } 
        catch(Exception $ex)
        { 
       		echo $ex;
            return response('Failed', 400);
        }
    }

    /* SHOW ALL ITEMS + USER'S NAME */
    public function show() {
    	try {

    		$items = DB::table('users')
	            ->join('items', 'items.user_id', '=', 'users.id')
	            ->select('items.id', 'items.user_id', 'users.name AS user_name', 'items.name', 'items.price', 'items.stock')
	            ->get();

            return response()->json($items, 200);
        }
        catch (Exception $ex) {
            return response($ex, 400);
        }
    }

    /* UPDATE AN ITEM */
    public function update($id, Request $request) {
        try {
            $item = $this->item->find($id)->update([
                "user_id" 	=> $request->user_id,
                "name" 		=> $request->name,
                "price" 	=> $request->price,
                "stock"		=> $request->stock    
            ]);

           	return response('Updated', 200);
        }
        catch(Exception $ex) { 
            return response('Failed',400);
        }
    }

    /* DELETE AN ITEM */
    public function delete($id) {
    	try {
    		$this->item->find($id)->delete();
    		return response('Deleted', 200);
    	}
    	catch (Exception $ex) {
    		return response('Failed', 400);
    	}
    }
}
