<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wayout;
use App\Wayin;
use App\Wayoutdetail;
use App\Waysale;
use App\Waysaledetail;
use App\Waycreditsale;
use App\Waycreditsaledetail;
use App\Product;
use App\Customer; 
use Carbon\Carbon;
use App\Promotion;
use App\Branch;
use App\Promotiondetail;
use App\Waypromotion;

class WaysaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wayouts_ongoing = Wayout::where([
            'wayin_status' => 'Ongoing',
            'status' => 'Active'
        ])->get();

        $wayouts_done = Wayout::where([
            'wayin_status' => 'Done',
            'status' => 'Active'
        ])->with('wayins')->orderby('wayout_date','asc')->get();

        $waysales = Waysale::all();

        $branches = Branch::all();

        return view('backend.waysales.index',compact('branches','wayouts_ongoing','wayouts_done','waysales'));

       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function waysale($id)
    {   
        $wayout = Wayout::find($id);
        $wayout_detail = Wayoutdetail::where('wayout_id',$id)->get();
        $customers = Customer::all();

        // product
        $product = Product::all();


        //check promotion

        $today = Carbon::now('Asia/Yangon');
        $promotion_status = Promotion::where('from','<',$today)->where('to','>',$today)->first();


        

        return view('backend.waysales.create',compact('wayout','product','wayout_detail','customers','promotion_status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function waysale_detail($id)
    {
        $id = request('id');

        $waysaleDetail = Waysaledetail::with('products')->where('waysale_id',$id)->get();

        return $waysaleDetail;
    }

    //prepare for print

    public function way_preparesale(Request $request)
    {

        $request->validate([
            'customer_name' => 'required'
        ]);

        $customer = Customer::where('id',request('customer_name'))->first();
        $method = request('sale_method');
        $discount = request('discount');
        $bonus = request('bonus');
        $branch_id = request('branch_id');
        $branch = Branch::find($branch_id);
        $wayout_id = request('wayout_id');
        

        // $number_row = Stock::where('branch_id',$branch_id)->get();
        $number_row = Wayoutdetail::where('wayout_id',$wayout_id)->with('wayout')->get();
        
        $rowcount = $number_row->count() + 1;

        $product_id = [];
        $product_name = [];
        $quantity = [];
        $sale_price = [];
        $amount   = [];

        $promo_product_id = [];
        $promo_quantity = [];
        $promo_product_name = [];


        $total_amount = 0;
        $balance = 0;
        


        //voucher No
        $way = "W";
        $waysale = Waysale::where('b_short','W')->orderby('voucher_no','desc')->first();
        $waycredit_sale = Waycreditsale::where('b_short','W')->orderby('voucher_no','desc')->first();


        if (empty($waysale->voucher_no) && empty($waycredit_sale->voucher_no)) {
            
                $first_word = $way;
                $number = 1;
                $voucher_no = $first_word.'-'.$number;
               

            }elseif (empty($waysale->voucher_no)) {

                $first_word = $way;
                $number = $waycredit_sale->voucher_no + 1;
                $voucher_no = $first_word.'-'.$number;
      
            }elseif (empty($waycredit_sale->voucher_no)) {

                $first_word = $way;
                $number = $waysale->voucher_no + 1;
                $voucher_no = $first_word.'-'.$number;

            }elseif ($waycredit_sale->voucher_no > $waysale->voucher_no) {

                $first_word = $way;
                $number = $waycredit_sale->voucher_no + 1;
                $voucher_no = $first_word.'-'.$number;

            }elseif ($waysale->voucher_no > $waycredit_sale->voucher_no) {

                $first_word = $way;
                $number = $waysale->voucher_no + 1;
                $voucher_no = $first_word.'-'.$number;

            }



        for ($i=1; $i < $rowcount; $i++) { 
            $p_product_id = request('promo_product_id'.$i);
            $p_quantity = request('promo_quantity'.$i);

            if ($p_quantity != Null) {

                $product = Product::where('id',$p_product_id)->first();
                $promo_product_id[] = $p_product_id;
                $promo_quantity[] = $p_quantity;
                $promo_product_name[] = $product->name;

            }

        }


        for($i=1 ; $i < $rowcount ; $i++){
                $productid = request('product_id'.$i);
                $input_quantity = request('sale_quantity'.$i);

                
                if ($input_quantity != null) {
                    $product = Product::where('id',$productid)->first();
                    $sale_price[] = $product->sale_price;
                    $product_id[] = $productid;
                    $product_name[] = $product->name;
                    $quantity[]   = $input_quantity;
                    $amount[]   = $input_quantity * $product->sale_price;
                    
                    
                }
            } //end of forloop

        //for total amount
        foreach ($amount as $sum) {

            $total_amount +=$sum;

        }

        // dd($amount);
        //for balance

        
        // dd($balance);
        if ($discount != null) {
            $discount_amount = $total_amount * $discount / 100;
            $balance = $total_amount - $discount_amount;
        }else{
            $discount_amount = 0;
            $balance = $total_amount;
        }

        if ($bonus != null) {
            $balance = $balance - $bonus;
        }else{
            $balance = $balance;
        }


        
        
        

        $today_date = Carbon::today()->toDateString();

        return view('backend.waysales.finalprint',compact('wayout_id','customer','method','discount','discount_amount','bonus','branch_id','product_id','product_name','quantity','amount','voucher_no','total_amount','balance','today_date','sale_price','promo_product_id','promo_quantity','promo_product_name'));
         


    }

    public function store(Request $request)
    {   
        
        $customer_id    = request('customer_id');
        $method         = request('method');
        $discount       = request('discount');
        $bonus          = request('bonus');
        $balance        = request('balance');
        $voucher_no     = request('voucher_no');
        $wayout_id      = request('wayout_id');



        //separte branch and Voucher_no
        $seperate = explode("-", $voucher_no);
        $first = current($seperate);
        $end = end($seperate);
        $int = (int)$end;
        


        // array

        $product_id     = request('product_id');
        $quantity       = request('quantity');
        $sale_price     = request('sale_price');
        $amount         = request('amount');
        $total_amount   = request('total_amount');

        // promotion
        $today = Carbon::now('Asia/Yangon');
        $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

        $promo_product_id = request('promo_product_id');
        $promo_quantity = request('promo_quantity');

        if (isset($promo_product_id)) {
            $promo_count = count($promo_product_id);

            for ($i=0; $i < $promo_count; $i++) { 
                
                $promotiondetail = new Promotiondetail;
                $promotiondetail->voucher_no = $voucher_no;
                $promotiondetail->promotion_id = $promotion->id;
                $promotiondetail->product_id = $promo_product_id[$i];
                $promotiondetail->quantity = $promo_quantity[$i];
                $promotiondetail->save();

                $wayout_stock = Wayoutdetail::where('wayout_id',$wayout_id)->where('product_id',$promo_product_id[$i])->first();
                $newquantity = $wayout_stock->quantity - $promo_quantity[$i];
                $wayout_stock->quantity = $newquantity;
                $wayout_stock->save();

            }
        }


        if ($method == "cash") {
            
            $count  = count($product_id);

            $waysale = New Waysale;
            $waysale->b_short = $first;
            $waysale->voucher_no   = $int;
            $waysale->wayout_id = $wayout_id;
            $waysale->customer_id  = $customer_id;
            $waysale->waysale_date     = Carbon::today()->toDateString();
            $waysale->total_amount = $total_amount;
            $waysale->discount     = $discount;
            $waysale->bonus        = $bonus;
            $waysale->balance      = $balance;
            $waysale->status = "Active";
            $waysale->save();

            for ($i=0; $i < $count; $i++) { 
                
                $waysaledetail                  =   New Waysaledetail;
                $waysaledetail->waysale_id      =   $waysale->id;
                $waysaledetail->product_id      =   $product_id[$i];
                $waysaledetail->quantity        =   $quantity[$i];
                $waysaledetail->amount          =   $amount[$i];
                $waysaledetail->save();

                $wayout_stock = Wayoutdetail::where('wayout_id',$wayout_id)->where('product_id',$product_id[$i])->first();
                $wayout_stock->quantity = $wayout_stock->quantity - $quantity[$i];
                $wayout_stock->save();

            }

        }else{

            
            $count  = count($product_id);

            $waycredit_sale = New Waycreditsale;
            $waycredit_sale->b_short = $first;
            $waycredit_sale->voucher_no   = $int;
            $waycredit_sale->wayout_id = $wayout_id;
            $waycredit_sale->customer_id  = $customer_id;
            $waycredit_sale->waysale_date     = Carbon::today()->toDateString();
            $waycredit_sale->total_amount = $total_amount;
            $waycredit_sale->credit_method= $method;
            $waycredit_sale->discount     = $discount;
            $waycredit_sale->bonus        = $bonus;
            $waycredit_sale->balance      = $balance;
            $waycredit_sale->status       = "Active";
            $waycredit_sale->save();

            for ($i=0; $i < $count; $i++) { 
                
                $waycredit_saledetail                  = New Waycreditsaledetail;
                $waycredit_saledetail->waycreditsale_id   = $waycredit_sale->id;
                $waycredit_saledetail->product_id      = $product_id[$i];
                $waycredit_saledetail->quantity        = $quantity[$i];
                $waycredit_saledetail->amount          = $amount[$i];
                $waycredit_saledetail->save();

                $wayout_stock = Wayoutdetail::where('wayout_id',$wayout_id)->where('product_id',$product_id[$i])->first();
                $wayout_stock->quantity = $wayout_stock->quantity - $quantity[$i];
                $wayout_stock->save();

            }

        }


        return redirect()->route('waysales.index')->with('successmsg','Successfully Make Way Sale '.$voucher_no);

 


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $waysale_detail = Waysale::with('Waysaledetails')->find($id);

        $promotion = Promotiondetail::where('voucher_no',$waysale_detail->b_short."-".$waysale_detail->voucher_no)->with('product')->get();

        return view('backend.waysales.show',compact('waysale_detail','promotion'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $id is waysale's id

        $waysale_details = Waysale::with('Waysaledetails')->find($id);

        $promotions = Promotiondetail::where('voucher_no',$waysale_details->b_short."-".$waysale_details->voucher_no)->with('product')->get();

        $way_stock = Wayout::with('wayoutdetails')->find($waysale_details->wayout_id);
        // dd($way_stock);
        // $way_stock = Wayoutdetail::where('wayout_id',$waysale_details->wayout_id)->get();
        // dd($way_stock);

        $product_id_arr = [];
        $promo_product_id_arr = [];


        foreach ($way_stock->wayoutdetails as $stock) {
            foreach ($waysale_details->waysaledetails as $detail) {
                if ($stock->product_id == $detail->product_id) {
                    $product_id_arr[] = $detail->product_id;
                }
            }
        }


        if (count($promotions) > 0) {
            foreach ($way_stock->wayoutdetails as $stock) {
                foreach ($promotions as $detail) {
                    if ($stock->product_id == $detail->product_id) {
                        $promo_product_id_arr[] = $detail->product_id;
                    }
                }
            }
        }

        
        $promo_arr = Wayoutdetail::where('wayout_id',$waysale_details->wayout_id)->whereNotIn('product_id',$promo_product_id_arr)->orderby('product_id','asc')->get();
        // dd($promo_arr);
        $stock_arr = Wayoutdetail::where('wayout_id',$waysale_details->wayout_id)->whereNotIn('product_id',$product_id_arr)->orderBy('product_id','asc')->get();
        // dd($stock_arr);
        //promotion_information

        $today = Carbon::now('Asia/Yangon'); 
        $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();
        $customers = Customer::all();

        return view('backend.waysales.edit',compact('way_stock','waysale_details','promotion','promotions','customers','promo_arr','stock_arr'));


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

            "customer_name" => 'required',
            "date"  => 'required'

        ]);

        
        $customer_id    =   request('customer_name');
        $bonus          =   request('bonus');
        $voucher_no     =   Waysale::select('b_short','voucher_no')->where('id',$id)->first();
        $discount       =   request('discount');
        $sale_method    =   request('sale_method');
        $sale_date      =   request('date');


        // for cash method
        if ($sale_method == "cash") {
            
            $detailrecords = Waysaledetail::where('waysale_id',$id)->get()->count();

            $num_row = $detailrecords + 1;
            $waysale   = Waysale::find($id);
            $total_amount = $waysale->total_amount;

            for ($i=1; $i < $num_row; $i++) { 
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {

                    $saledetail_delete = Waysaledetail::where('waysale_id',$id)->where('product_id',$product_id)->first();

                    $way_stock = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$product_id)->first();
                    // dd($saledetail_delete->sale_return);
                    // if (isset($saledetail_delete->sale_return)) {    
                    //     $new_quantity = $saledetail_delete->quantity - $saledetail_delete->sale_return;
                    //     // dd($new_quantity);
                    // }else{
                    //     $new_quantity = $saledetail_delete->quantity;
                    // }

                    $way_stock->quantity = $way_stock->quantity + $quantity;
                    $way_stock->save();

                    $total_amount = $total_amount   -   $saledetail_delete->amount;

                    $saledetail_delete->delete();

                }else{

                    $saledetail = Waysaledetail::where('waysale_id',$id)->where('product_id',$product_id)->first();
                    $product    = Product::where('id',$product_id)->first();

                    if ($quantity < $saledetail->quantity) {
                        
                        // if (isset($saledetail->sale_return)) {
                        //     $newquantity = $saledetail->quantity - $quantity - $saledetail->sale_return;
                        // }else{
                        //     $newquantity = $saledetail->quantity - $quantity;
                        // }
                        $newquantity = $saledetail->quantity - $quantity;

                        $amount         =   $quantity * $product->sale_price;
                        
                        $total_amount   =   $total_amount - $saledetail->amount + $amount;

                        $saledetail->amount   = $amount;
                        $saledetail->quantity = $quantity;
                        $saledetail->save();

                        
                        $way_stock = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$product_id)->first();
                        $way_stock->quantity = $way_stock->quantity + $newquantity;
                        
                        $way_stock->save();

                    }elseif($quantity > $saledetail->quantity){

                        $newquantity = $quantity - $saledetail->quantity;
                        $amount         =   $quantity * $product->sale_price;

                        $total_amount   =   $total_amount - $saledetail->amount + $amount;

                        $saledetail->amount   = $amount;
                        $saledetail->quantity = $quantity;
                        $saledetail->save();

                        $way_stock = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$product_id)->first();
                        $way_stock->quantity = $way_stock->quantity - $newquantity;
                        $way_stock->save();

                    }

                }

            }


            $number_row = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->get()->count();
            $rowcount = $number_row + 1;

            // add new product

            for ($j=1; $j < $rowcount; $j++) { 
                $add_product_id = request('add_product_id'.$j);
                $add_quantity = request('add_quantity'.$j);
                

                if ($add_quantity == !null) {
                    $product    =   Product::where('id',$add_product_id)->first();
                    $amount     =   $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;


                    $saledetail = new Waysaledetail;
                    $saledetail->waysale_id = $id;
                    $saledetail->product_id = $add_product_id;
                    $saledetail->quantity = $add_quantity;
                    $saledetail->amount   = $amount;
                    $saledetail->save();

                    $stock_check = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$add_product_id)->first();
                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();         
                    
                }

            }
            //end of adding new product

            $waysale->customer_id  =    $customer_id;
            $waysale->total_amount =    $total_amount;
            $waysale->bonus        =    $bonus;
            $waysale->discount     =    $discount;
            $waysale->waysale_date =    $sale_date;

            
            $minus_discount        =   $total_amount * $discount / 100;
            $final_balance         =   $total_amount - $minus_discount - $bonus;  
            $waysale->balance      =   $final_balance;
            $waysale->save();

            //new add promotion product start


            $promotiondetail = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail);
                
                for ($i=1; $i <= $count ; $i++) { 
                    
                    $delete = request('promo_delete'.$i);
                    $promo_product = request('promo_product_id'.$i);
                    $promo_quantity = request('promo_quantity'.$i);
                    
                    if ($delete == "Delete") {
                        
                        $promo_delete = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->where('product_id',$promo_product)->first();


                        $stock_add = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$promo_product)->first();
                        $stock_add->quantity = $stock_add->quantity + $promo_delete->quantity;
                        $stock_add->save();

                        $promo_delete->delete();


                    }else{
                        $promotion = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->where('product_id',$promo_product)->first();
                        // dd($promotion);
                        if ($promotion->quantity < $promo_quantity) {
                            
                            $new_quantity = $promo_quantity - $promotion->quantity;
                            $stock_add = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$promo_product)->first();
                            $stock_add->quantity = $stock_add->quantity - $new_quantity;
                            $stock_add->save();


                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }elseif ($promotion->quantity > $promo_quantity) {
                            
                            $new_quantity = $promotion->quantity - $promo_quantity;
                            $stock = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$promo_product)->first();
                            $stock->quantity = $stock->quantity + $new_quantity;
                            $stock->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }

                    }


                }  // For loop end

            } // have promotion if end

            

            $number_row = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->get()->count();    

            for ($i=1; $i <= $number_row; $i++) { 
                
                $new_promo_product = request('add_promo_id'.$i);
                $new_promo_quantity = request('add_promo_quantity'.$i);
                
                if ($new_promo_quantity != Null) {
                    
                    $today = Carbon::now('Asia/Yangon');
                    $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

                    $stock = Wayoutdetail::where('wayout_id',$waysale->wayout_id)->where('product_id',$new_promo_product)->first();
                    $stock->quantity = $stock->quantity - $new_promo_quantity;
                    $stock->save();

                    $promo_detail = new Promotiondetail;
                    $promo_detail->voucher_no = $waysale->b_short.'-'.$waysale->voucher_no;

                    if ($promotion == Null) {
                        $promo_detail->promotion_id = '1';
                    }else{
                        $promo_detail->promotion_id = $promotion->id;
                    }

                    $promo_detail->product_id = $new_promo_product;
                    $promo_detail->quantity = $new_promo_quantity;
                    $promo_detail->save();

                }

            }

            return redirect()->route('way_sale_detail',$waysale->wayout_id)->with('successmsg','Voucher no- '.$voucher_no->b_short."-".$voucher_no->voucher_no.' Successfully Update');

        }

        // for end cash mehtod

        //start credit method ================================================================

        if ($sale_method == "credit" || $sale_method == "1week" || $sale_method == "2week") {
            
            $detailrecords = Waysaledetail::where('waysale_id',$id)->get();
            $num_row = count($detailrecords) + 1;
            $sale   = Waysale::find($id);

            $credit_sale = New Waycreditsale;
            $credit_sale->b_short = $sale->b_short;
            $credit_sale->voucher_no = $sale->voucher_no;
            $credit_sale->wayout_id = $sale->wayout_id;
            $credit_sale->customer_id = $sale->customer_id;
            $credit_sale->waysale_date = $sale->waysale_date;
            $credit_sale->credit_method = $sale_method;
            $credit_sale->total_amount = $sale->total_amount;
            $credit_sale->discount = $sale->discount;
            $credit_sale->bonus = $sale->bonus;
            $credit_sale->balance = $sale->balance;
            $credit_sale->status = "Active";
            $credit_sale->save();

            foreach ($detailrecords as $sale_detail) {

                $credit_saledetail = New Waycreditsaledetail;
                $credit_saledetail->waycreditsale_id = $credit_sale->id;
                $credit_saledetail->product_id = $sale_detail->product_id;
                $credit_saledetail->quantity    = $sale_detail->quantity;
                $credit_saledetail->amount      = $sale_detail->amount;
                $credit_saledetail->save();

            }

            $sale->delete();

            
            $credit_count = Waycreditsaledetail::where('waycreditsale_id',$credit_sale->id )->get()->count();
            $num_row = $credit_count + 1;
            $total_amount = $credit_sale->total_amount;

            for ($i=1; $i < $num_row ; $i++) { 
                
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {
                    
                    $creditdetail_delete = Waycreditsaledetail::where('waycreditsale_id',$credit_sale->id)->where('product_id',$product_id)->first();

                    $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();

                    $stock->quantity = $stock->quantity + $creditdetail_delete->quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $creditdetail_delete->amount;

                    $creditdetail_delete->delete();

                }else{

                    $creditdetail = Waycreditsaledetail::where('waycreditsale_id',$credit_sale->id)->where('product_id',$product_id)->first();
                    $product    = Product::where('id',$product_id)->first();

                    if ($quantity < $creditdetail->quantity) {
                        
                        $newquantity = $creditdetail->quantity - $quantity;
                        $amount = $quantity * $product->sale_price;

                        $total_amount = $total_amount - $creditdetail->amount + $amount;

                        $creditdetail->amount = $amount;
                        $creditdetail->quantity = $quantity;
                        $creditdetail->save();

                        // $stock = Stock::where('branch_id',$credit_sale->id)->where('product_id',$product_id)->first();
                        $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity + $newquantity;
                        $stock->save();

                    }elseif($quantity > $creditdetail->quantity){

                        $newquantity = $quantity - $creditdetail->quantity;
                        $amount         =   $quantity * $product->sale_price;

                        $total_amount   =   $total_amount - $creditdetail->amount + $amount;

                        $creditdetail->amount   = $amount;
                        $creditdetail->quantity = $quantity;
                        $creditdetail->save();

                        

                        // $stock = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$product_id)->first();
                        $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity - $newquantity;
                        $stock->save();

                    }


                }


            }

            $number_row = Wayoutdetail::where('wayout_id',$sale->wayout_id)->get()->count();
            $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $rowcount; $i++) { 
                
                $add_product_id = request('add_product_id'.$i);
                $add_quantity = request('add_quantity'.$i);
                
                if ($add_quantity == !null) {
                    
                    $product = Product::where('id',$add_product_id)->first();
                    $amount = $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;

                    $creditdetail = New Waycreditsaledetail;
                    $creditdetail->waycreditsale_id = $credit_sale->id;
                    $creditdetail->product_id = $add_product_id;
                    $creditdetail->quantity = $add_quantity;
                    $creditdetail->amount = $amount;
                    $creditdetail->save();

                    $stock_check = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$add_product_id)->first();

                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();

                }

            }

            $update_creditsale = Waycreditsale::find($credit_sale->id);
            $update_creditsale->customer_id = $customer_id;
            $update_creditsale->total_amount = $total_amount;
            $update_creditsale->bonus = $bonus;
            $update_creditsale->discount = $discount;
            $update_creditsale->waysale_date = $sale_date;
            $update_creditsale->credit_method =  $sale_method;

            $minus_discount     =   $total_amount * $discount / 100;
            // $minus_bonus        =   $total_amount - $bonus;
            $final_balance      =   $total_amount - $minus_discount - $bonus;
           
            $update_creditsale->balance      =   $final_balance;
            $update_creditsale->save();

            $promotiondetail = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail);

                for ($i=1; $i <= $count ; $i++) { 
                    
                    $delete = request('promo_delete'.$i);
                    $promo_product = request('promo_product_id'.$i);
                    $promo_quantity = request('promo_quantity'.$i);
                   

                    if ($delete == "Delete") {
                        
                        $promo_delete = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->where('product_id',$promo_product)->first();

                        // dd($promo_product);

                        $stock_add = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$promo_product)->first();
                        $stock_add->quantity = $stock_add->quantity + $promo_delete->quantity;
                        $stock_add->save();

                        $promo_delete->delete();

                    }else{

                        $promotion = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->where('product_id',$promo_product)->first();

                        if ($promotion->quantity < $promo_quantity) {
                            
                            $new_quantity = $promo_quantity - $promotion->quantity;

                            $stock_add = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$promo_product)->first();
                            $stock_add->quantity = $stock_add->quantity - $new_quantity;
                            $stock_add->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }elseif ($promotion->quantity > $promo_quantity) {
                            
                            $new_quantity = $promotion->quantity - $promo_quantity;
                            $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$promo_product)->first();
                            $stock->quantity = $stock->quantity + $new_quantity;
                            $stock->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }

                    }


                }

            }

            

            $number_row = Wayoutdetail::where('wayout_id',$sale->wayout_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $number_row; $i++) { 
                
                $new_promo_product = request('add_promo_id'.$i);
                $new_promo_quantity = request('add_promo_quantity'.$i);

                if ($new_promo_quantity != Null) {
                    
                    $today = Carbon::now('Asia/Yangon');
                    $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

                    $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$new_promo_product)->first();
                    $stock->quantity = $stock->quantity - $new_promo_quantity;
                    $stock->save();

                    $promo_detail = new Promotiondetail;
                    $promo_detail->voucher_no = $voucher_no->b_short."-".$voucher_no->voucher_no;

                    if ($promotion->id == Null) {
                        $promo_detail->promotion_id = '1';
                    }else{
                        $promo_detail->promotion_id = $promotion->id;
                    }
                    
                    $promo_detail->product_id = $new_promo_product;
                    $promo_detail->quantity = $new_promo_quantity;
                    $promo_detail->save();

                }

            }
            
            return redirect()->route('way_sale_detail',$sale->wayout_id)->with('successmsg','Voucher no- '.$voucher_no->b_short."-".$voucher_no->voucher_no.' Successfully Update');

        } //end credit mehtod

        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $waysale = Waysale::find($id);
        
        $waysaledetail = Waysaledetail::where('waysale_id',$id)->get();

        foreach ($waysaledetail as $detail) {
            $add_stock = Wayoutdetail::where(['wayout_id'=>$waysale->wayout_id,'product_id'=>$detail->product_id])->first();
            
            if ($add_stock == !null) {

                $add_stock->quantity = $add_stock->quantity + $detail->quantity ;
                $add_stock->save();

            }else{

            }
        }

        $voucher_no = $waysale->b_short."-".$waysale->voucher_no;
        $promo_items = Promotiondetail::where('voucher_no',$voucher_no)->get();

        if (count($promo_items) > 0) {
            
            foreach ($promo_items as $item) {
                $wayout = Wayoutdetail::where(['wayout_id'=>$waysale->wayout_id,'product_id'=>$item->product_id])->first();
                $items = Promotiondetail::where('voucher_no',$voucher_no)->where('product_id',$item->product_id)->first();
                if ($wayout != null) {
                   $wayout->quantity = $wayout->quantity + $item->quantity;
                   $wayout->save(); 
                }else{
                    $wayout = New Stock;
                    $wayout->branch_id = $sale->branch_id;
                    $wayout->product_id = $item->product_id;
                    $wayout->quantity = $item->quantity;
                    $wayout->save();
                }
                $items->delete();
            }

        }

        $waysale->status = "Deactive";
        $waysale->save();

        return redirect()->route('way_sale_detail',$waysale->wayout_id)->with('successmsg','Voucher_no = $voucher_no is Successfully Cancelled !!');

    }


    public function way_sale_detail($id)
    {
        $wayout = Wayout::find($id);
        $waySales = Waysale::where(['wayout_id'=>$id,'status'=>'Active'])->orderby('voucher_no','asc')->get(); 

        $wayCreditSales = Waycreditsale::where(['wayout_id'=>$wayout->id,'status'=>'Active'])->orderby('voucher_no','asc')->get();

        // cancel Record
        $cancel_waySales = Waysale::where(['wayout_id'=>$wayout->id,'status'=>'Deactive'])->orderby('voucher_no','asc')->get(); 

        $cancel_wayCreditSales = Waycreditsale::where(['wayout_id'=>$wayout->id,'status'=>'Deactive'])->orderby('voucher_no','asc')->get();
        
        return view('backend.waysales.detail',compact('waySales','wayCreditSales','wayout','cancel_waySales','cancel_wayCreditSales'));

    }

}
