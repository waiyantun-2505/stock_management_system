<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transfer;
use App\Subcategory;
use App\Product;
use Carbon\Carbon;
use App\Branch;
use App\Stock;
use App\Transferdetail;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transfers  = Transfer::orderby('transfer_date','desc')->paginate(10);

        $branches   = Branch::all();

        return view('backend.transfers.index',compact('transfers','branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::all();

        return view('backend.transfers.create',compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "branchname1" => 'required',
            "branchname2" => 'required'
        ]);

        $transfer = new Transfer;
        $transfer->transfer_date = Carbon::today()->toDateString();
        $transfer->from_branch = request('branchname1');
        $transfer->to_branch = request('branchname2');
        $transfer->save();

        $number_row = Product::all();
        $rowcount = $number_row->count() + 1;
        // dd($rowcount);

        $f_branch_stock = Stock::where('branch_id',request('branchname1'))->get();
        $t_branch_stock = Stock::where('branch_id',request('branchname2'))->get(); 

        // dd($f_branch_stock);

        for( $i=1 ; $i<$rowcount; $i++ ) { 

            $product_id = request("product_id".$i);
            $quantity = request("quantity".$i);
            // dd($product_id);

            if ($quantity == !null ) {
                $subtract_stock = Stock::where('product_id', $product_id)->where('branch_id',request('branchname1'))->first();
                // dd($subtract_stock);
                $current_quantity = $subtract_stock->quantity;
                $subtract_amount = $quantity;
                $f_total = $current_quantity - $subtract_amount;

                $f_update = Stock::find($subtract_stock->id);
                $f_update->quantity = $f_total;
                $f_update->save();

                $add_stock = Stock::where('branch_id',request('branchname2'))->where('product_id',$product_id)->first();

                if ($quantity == !null && $add_stock == !null) {

                    $t_current_stock = $add_stock->quantity;
                    $t_total = $t_current_stock + $quantity;

                     $t_update = Stock::find($add_stock->id);
                     $t_update->quantity= $t_total;
                     $t_update->save();
                }

                if ($quantity == !null && $add_stock == null) {
                    
                    $stock = new Stock;

                    $stock->quantity = $quantity;
                    $stock->product_id = $product_id;
                    $stock->branch_id = request('branchname2');
                    $stock->save();
                }

                $transferDetail = new Transferdetail;
                $transferDetail->transfer_id = $transfer->id;
                $transferDetail->product_id = $product_id;
                $transferDetail->quantity = $quantity;
                $transferDetail->save();



            }

            
        }

        return redirect()->route('transfers.index')->with('successmsg','Succesfully Save');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $transfer   =   Transfer::find($id);
        $transferdetail = Transferdetail::where('transfer_id',$id)->get();
        $branches   = Branch::all();

        $new_product;

        $stocks = Stock::where('branch_id',$transfer->from_branch)->get();

        foreach ($stocks as $stock) {
            foreach ($transferdetail as $detail) {
                if ($stock->product_id == $detail->product_id) {
                    $new_product[] = $detail->product->id;
                }
            }
        }
        $new_stocks = Stock::where('branch_id',$transfer->from_branch)->wherenotin('product_id',$new_product)->get();
        


        return view('backend.transfers.edit',compact('transfer','transferdetail','branches','stocks','new_stocks'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required'
        ]);

        $transferdetail_count =   Transferdetail::where('transfer_id',$id)->get()->count();
        $count          =   $transferdetail_count + 1;
        $date           =   request('date');

        $transfer   =   Transfer::find($id);
        $transfer->transfer_date = $date;
        $transfer->save();

        for ($i=1; $i < $count ; $i++) { 
            
            $delete = request('delete'.$i);
            $old_product_id = request('old_product_id'.$i);
            $old_quantity   = request('old_quantity'.$i);

            $transferdetail = Transferdetail::where('transfer_id',$id)->where('product_id',$old_product_id)->first();

            if ($delete == "Delete") {         

                //deduct form old branch
                $to_branch = Stock::where('branch_id',$transfer->to_branch)->where('product_id',$old_product_id)->first();
                $to_branch->quantity = $to_branch->quantity - $transferdetail->quantity;
                $to_branch->save();

                $stock = Stock::where('branch_id',$transfer->from_branch)->where('product_id',$old_product_id)->first();
                $stock->quantity = $stock->quantity + $transferdetail->quantity;
                $stock->save();

                $transferdetail->delete();

            }elseif($old_quantity < $transferdetail->quantity){

                $newquantity = $transferdetail->quantity - $old_quantity;

                $transferdetail->quantity = $old_quantity;
                $transferdetail->save();

                $to_branch = Stock::where('branch_id',$transfer->to_branch)->where('product_id',$old_product_id)->first();
                $to_branch->quantity = $to_branch->quantity - $newquantity;
                $to_branch->save();

                $stock = Stock::where('branch_id',$transfer->from_branch)->where('product_id',$old_product_id)->first();
                $stock->quantity = $stock->quantity + $newquantity;
                $stock->save();
                
               

            }elseif($old_quantity > $transferdetail->quantity){

                $newquantity = $old_quantity - $transferdetail->quantity;

                $transferdetail->quantity = $old_quantity;
                $transferdetail->save();

                $to_branch = Stock::where('branch_id',$transfer->to_branch)->where('product_id',$old_product_id)->first();
                $to_branch->quantity = $to_branch->quantity + $newquantity;
                $to_branch->save();

                $stock = Stock::where('branch_id',$transfer->from_branch)->where('product_id',$old_product_id)->first();
                $stock->quantity = $stock->quantity - $newquantity;
                $stock->save();

            }elseif($old_quantity == $transferdetail->quantity) {
                    
                $transferdetail->quantity = $old_quantity;
                $transferdetail->save();

            }
        } //end for loop

        //add new products
        $product = Product::all()->count();
        $count = $product+1;

            for ($j=1; $j < $count; $j++) { 
                
                $new_product = request('new_product'.$i);
                $new_quantity = request('new_quantity'.$i);

                if ($new_quantity != Null) {
                    
                    $transferdetail = New Transferdetail;
                    $transferdetail->transfer_id = $id;
                    $transferdetail->product_id = $new_product;
                    $transferdetail->quantity = $new_quantity;
                    $transferdetail->save();

                    $stock = Stock::where('branch_id',$transfer->from_branch)->where('product_id',$new_product)->first();
                    $stock->quantity = $stock->quanity - $new_quantity;
                    $stock->save();

                }

            }

            return redirect()->route('transfers.index')->with('successmsg','Succesfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $transfer = Transfer::find($id);
        $transferdetail = Transferdetail::where('transfer_id',$id)->get();

        foreach ($transferdetail as $detail) {
            
            $from_branch = Stock::where('branch_id',$transfer->from_branch)->where('product_id',$detail->product_id)->first();
            $from_branch->quantity = $from_branch->quantity + $detail->quantity;


            $to_branch = Stock::where('branch_id',$transfer->to_branch)->where('product_id',$detail->product_id)->first();
            $to_branch->quantity = $to_branch->quantity - $detail->quantity;

            if ($to_branch->quantity < 0 ) {
                return redirect()->route('transfers.index')->with('successmsg','Failed To Delete!! '.$to_branch->product->name.' have not enough quantity.');
            }else{
                $from_branch->save();
                $to_branch->save();
            }


        }
        $transfer->delete();

        return redirect()->route('transfers.index')->with('successmsg','Succesfully Deleted');



    }
}
