<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Stock;
use App\Wayout;
use App\Wayoutdetail;
use App\Product;
use Carbon\Carbon;
use App\Waystockadd;
use App\Waystockadddetail;

class WayaddstockController extends Controller
{
    
	public function wayadd_form(Request $request , $id)
	{
		$branch_id = request('branch_id');

		$branch	= Branch::where('id', $branch_id)->first();
		$stocks 	= Stock::where('branch_id', $branch_id)->orderBy('product_id','asc')->get();
		$wayoutstocks = Wayout::where('id',$id)->with('wayoutdetails')->first();
		
		

		return view('backend.wayaddstocks.create',compact('branch','stocks','wayoutstocks'));

	}

	public function wayadd_pending()
	{
		
		$pending_branches = Waystockadd::where('send_status','Pending')->select('branch_id')->get()->unique('branch_id');
		$pending_records = Waystockadd::where('send_status','Pending')->get();

		return view('backend.wayaddstocks.index',compact('pending_branches','pending_records'));

	}

	public function wayadd_store(Request $request, $id)
	{	
		
		$branch_id = request('branch_id');

		$count = count(Stock::where('branch_id',$branch_id)->get()) + 1;

		$quantity = [];
		for ($i=1; $i < $count; $i++) { 
			$add_product = request('add_product'.$i);
			$add_quantity = request('add_quantity'.$i);

			$quantity[] = $add_quantity;
		}

		$remove_null = array_filter($quantity,'strlen');

		

		if (count($remove_null) > 0) {
			
			// save Waystock add
			$waystockadd = New Waystockadd;
			$waystockadd->wayout_id = $id;
			$waystockadd->branch_id = $branch_id;
			$waystockadd->wayadd_date = Carbon::today()->toDateString();
			$waystockadd->send_status = "Pending";
			$waystockadd->status = "Active";
			$waystockadd->save();

			for ($i=1; $i < $count; $i++) { 
			
				$add_product = request('add_product_id'.$i);
				$add_quantity = request('add_quantity'.$i);
			

				if ($add_quantity != Null) {
						
					// deduct from stock
					$stock = Stock::where('branch_id',$branch_id)->where('product_id',$add_product)->first();
					
					$stock->quantity = $stock->quantity - $add_quantity;
					$stock->save();

					// add quantity to wayout
					$wayoutdetail = Wayoutdetail::where('wayout_id',$id)->where('product_id',$add_product)->first();

					if ($wayoutdetail == Null) {
						$new_wayoutstock = New Wayoutdetail;
						$new_wayoutstock->wayout_id = $id;
						$new_wayoutstock->product_id = $add_product;
						$new_wayoutstock->quantity = $add_quantity;
						$new_wayoutstock->save();
					}else{
						$wayoutdetail->quantity = $wayoutdetail->quantity + $add_quantity;
						$wayoutdetail->save();
					}

					

					//add stock to waystockadd detail
					$waystockadd_detail = New Waystockadddetail;
					$waystockadd_detail->waystockadd_id = $waystockadd->id;
					$waystockadd_detail->product_id = $add_product;
					$waystockadd_detail->quantity = $add_quantity;
					$waystockadd_detail->save();

				}


			}

			return redirect()->route('waysales.index')->with('successmsg','Successfully Added.');

		}else{
			return redirect()->route('wayadd_form',['branch_id'=>$branch_id,'id'=>$id])->with('successmsg','Fill atlesast 1 Quantity');
		}

		

	}

}
