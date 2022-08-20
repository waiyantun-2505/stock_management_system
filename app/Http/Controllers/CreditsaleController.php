<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\Customer;
use App\Product;
use App\Subcategory;
use App\Stock;
use App\Branch;
use App\Saledetail;
use Carbon\Carbon;
use App\Creditsale;
use App\Creditsaledetail;
use App\Promotiondetail;
use App\Promotion;

class CreditsaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $creditsales = Creditsale::find($id);
        $voucher_no = $creditsales->b_short.'-'.$creditsales->voucher_no;

        // dd($voucher_no);

        // dd($creditsales);

        $credit_saledetail = Creditsaledetail::where('creditsale_id',$id)->get();

        $promotion = Promotiondetail::where('voucher_no',$voucher_no)->get();

        $credit_sale_return = Creditsaledetail::where('creditsale_id',$id)->where('sale_return','!=','Null')->get();



        return view('backend.creditsales.show',compact('creditsales','credit_saledetail','promotion','credit_sale_return'));

    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $creditsale = Creditsale::find($id);
        $voucher_no = $creditsale->b_short.'-'.$creditsale->voucher_no;

        $creditsaledetail = Creditsaledetail::where('creditsale_id',$id)->get();
        // dd($sale->branch_id);
        $stocks = Stock::where('branch_id',$creditsale->branch_id)->orderby('product_id','asc')->get();

        $promotiondetail = Promotiondetail::where('voucher_no',$voucher_no)->get();

        $promo_product_id_arr = []; 

        $product_id_arr = [];     

        foreach ($stocks as $stock) {
            foreach ($creditsaledetail as $detail) {
                if ($stock->product_id == $detail->product_id) {
                    $product_id_arr[] = $detail->product_id;
                }
            }
        }

        if (count($promotiondetail) > 0) {
            foreach ($stocks as $stock) {
                foreach ($promotiondetail as $detail) {
                    if ($stock->product_id == $detail->product_id) {
                        $promo_product_id_arr[] = $detail->product_id;
                    }
                }
            }
        }

        $promo_arr = Stock::where('branch_id',$creditsale->branch_id)->wherenotIn('product_id',$promo_product_id_arr)->orderby('product_id','asc')->get();

        // dd($promotiondetail);

        $stock_arr = Stock::where('branch_id',$creditsale->branch_id)->whereNotIn('product_id',$product_id_arr)->orderBy('product_id','asc')->get();

        // dd($stock_arr);

        $product = Product::with('subcategory')->get();
        $customers = Customer::all();


        //promotion_information

        $today = Carbon::now('Asia/Yangon'); 

        $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

        return view('backend.creditsales.edit',compact('creditsale','customers','creditsaledetail','stocks','product','stock_arr','promo_arr','promotiondetail','promotion'));

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
        $branch_id      =   Creditsale::select('branch_id')->where('id',$id)->first();
        $voucher_no     =   Creditsale::select('voucher_no')->where('id',$id)->first();
        $discount       =   request('discount');
        $sale_method    =   request('sale_method');
        $sale_date      =   request('date');

        // dd($sale_method);

        if ($sale_method == "credit" || $sale_method == "1week" || $sale_method == "2week") {
            
            $detailrecords = Creditsaledetail::where('creditsale_id',$id)->get()->count();
            $num_row = $detailrecords + 1;
            $creditsale   = Creditsale::find($id);
            $total_amount = $creditsale->total_amount;

            for ($i=1; $i < $num_row ; $i++) { 
                
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {
                    
                    $credit_detail_delete = Creditsaledetail::where('creditsale_id',$id)->where('product_id',$product_id)->first();

                    $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$product_id)->first();
                    $stock->quantity = $stock->quantity + $credit_detail_delete->quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $credit_detail_delete->amount;

                    $credit_detail_delete->delete();

                }else{ 

                    $credit_saledetail = Creditsaledetail::where('creditsale_id',$id)->where('product_id',$product_id)->first();
                    $product    = Product::where('id',$product_id)->first();

                    if ($quantity < $credit_saledetail->quantity) {
                        $newquantity = $credit_saledetail->quantity - $quantity;
                        $amount         =   $quantity * $product->sale_price;
                        
                        $total_amount   =   $total_amount - $credit_saledetail->amount + $amount;

                        $credit_saledetail->amount   = $amount;
                        $credit_saledetail->quantity = $quantity;
                        $credit_saledetail->save();


                        $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity + $newquantity;
                        
                        $stock->save();

                    }elseif($quantity > $credit_saledetail->quantity){
                        $newquantity = $quantity - $credit_saledetail->quantity;
                        $amount         =   $quantity * $product->sale_price;

                        $total_amount   =   $total_amount - $credit_saledetail->amount + $amount;

                        $credit_saledetail->amount   = $amount;
                        $credit_saledetail->quantity = $quantity;
                        $credit_saledetail->save();

                        

                        $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity - $newquantity;
                        $stock->save();

                    }

                } 

            } //for loop end

            $number_row = Stock::where('branch_id',$creditsale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $rowcount ; $i++) { 
                
                $add_product_id = request('add_product_id'.$i);
                $add_quantity = request('add_quantity'.$i);

                if ($add_quantity != Null) {
                    
                    $product    = Product::where('id',$add_product_id)->first();
                    $amount     =   $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;

                    $credit_saledetail = new Saledetail;
                    $credit_saledetail->creditsale_id = $id;
                    $credit_saledetail->product_id = $add_product_id;
                    $credit_saledetail->quantity = $add_quantity;
                    $credit_saledetail->amount   = $amount;
                    $credit_saledetail->save();

                    $stock_check = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$add_product_id)->first();
                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();

                }

            } //end of adding new product

            $creditsale->customer_id  = $customer_id;
            $creditsale->total_amount = $total_amount;
            $creditsale->bonus        = $bonus;
            $creditsale->credit_method= $sale_method;
            $creditsale->discount     = $discount;
            $creditsale->saledate     = $sale_date;

            $minus_discount     =   $total_amount * $discount / 100;
            
            $final_balance      =   $total_amount - $minus_discount - $bonus;
           
            $creditsale->balance      =   $final_balance;
            $creditsale->save();

            //promotion stage

            $promotiondetail = Promotiondetail::where('voucher_no',$creditsale->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail);

                for ($i=1; $i <= $count ; $i++) { 
                    
                    $delete = request('promo_delete'.$i);
                    $promo_product = request('promo_product_id'.$i);
                    $promo_quantity = request('promo_quantity'.$i);

                    if ($delete == "Delete") {
                        
                        $promo_delete = Promotiondetail::where('voucher_no',$creditsale->voucher_no)->where('product_id',$promo_product)->first();

                        $stock_add = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$promo_product)->first();
                        $stock_add->quantity = $stock_add->quantity + $promo_delete->quantity;
                        $stock_add->save();

                        $promo_delete->delete();

                    }else{

                        $promotion = Promotiondetail::where('voucher_no',$creditsale->voucher_no)->where('product_id',$promo_product)->first();

                        if ($promotion->quantity < $promo_quantity) {
                            
                            $new_quantity = $promo_quantity - $promotion->quantity;

                            $stock_add = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$promo_product)->first();
                            $stock_add->quantity = $stock_add->quantity - $new_quantity;
                            $stock_add->save();


                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }elseif ($promotion->quantity > $promo_quantity) {
                            
                            $new_quantity = $promotion->quantity - $promo_quantity;
                            $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$promo_product)->first();
                            $stock->quantity = $stock->quantity + $new_quantity;
                            $stock->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }

                    }

                } //end of for loop

            } //promotion stage end

            // adding new promotion items

            $number_row = Stock::where('branch_id',$creditsale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $number_row; $i++) { 
                
                $new_promo_product = request('add_promo_id'.$i);
                $new_promo_quantity = request('add_promo_quantity'.$i);

                if ($new_promo_quantity != Null) {
                    
                    $today = Carbon::now('Asia/Yangon');
                    $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

                    $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$new_promo_product)->first();
                    $stock->quantity = $stock->quantity - $new_promo_quantity;
                    $stock->save();

                    $promo_detail = new Promotiondetail;
                    $promo_detail->voucher_no = $creditsale->voucher_no;
                    $promo_detail->promotion_id = $promotion->id;
                    $promo_detail->product_id = $new_promo_product;
                    $promo_detail->quantity = $new_promo_quantity;
                    $promo_detail->save();

                }

            }



        }   // Credit method if end 

        //start cash Method

        if ($sale_method == "cash") {
            
            $detailrecords = Creditsaledetail::where('creditsale_id',$id)->get();
            $num_row = count($detailrecords) + 1;
            $credit_sale   = Creditsale::find($id);

            $sale = New Sale;
            $sale->voucher_no = $credit_sale->voucher_no;
            $sale->customer_id = $credit_sale->customer_id;
            $sale->branch_id = $credit_sale->branch_id;
            $sale->saledate = $credit_sale->saledate;
            $sale->total_amount = $credit_sale->total_amount;
            $sale->discount = $credit_sale->discount;
            $sale->bonus = $credit_sale->bonus;
            $sale->balance = $credit_sale->balance;
            $sale->status = "Active";
            $sale->save();

            foreach ($detailrecords as $creditsale_detail) {

                $saledetail = New Saledetail;
                $saledetail->sale_id = $sale->id;
                $saledetail->product_id = $creditsale_detail->product_id;
                $saledetail->sale_return = $creditsale_detail->sale_return;
                $saledetail->return_date = $creditsale_detail->return_date;
                $saledetail->quantity    = $creditsale_detail->quantity;
                $saledetail->amount      = $creditsale_detail->amount;
                $saledetail->save();

            }

            $credit_sale->delete();

            
            $saledetail_count = Saledetail::where('sale_id',$sale->id )->get()->count();
            $num_row = $saledetail_count + 1;
            $total_amount = $sale->total_amount;

            for ($i=1; $i < $num_row ; $i++) { 
                
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {
                    
                    $saledetail_delete = Saledetail::where('sale_id',$sale->id)->where('product_id',$product_id)->first();

                    $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$product_id)->first();

                    $stock->quantity = $stock->quantity + $saledetail_delete->quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $saledetail_delete->amount;

                    $saledetail_delete->delete();

                }else{

                    $saledetail = Saledetail::where('sale_id',$sale->id)->where('product_id',$product_id)->first();
                    $product    = Product::where('id',$product_id)->first();

                    if ($quantity < $saledetail->quantity) {
                        
                        $newquantity = $saledetail->quantity - $quantity;
                        $amount = $quantity * $product->sale_price;

                        $total_amount = $total_amount - $saledetail->amount + $amount;

                        $saledetail->amount = $amount;
                        $saledetail->quantity = $quantity;
                        $saledetail->save();

                        $stock = Stock::where('branch_id',$sale->id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity + $newquantity;
                        $stock->save();

                    }elseif($quantity > $saledetail->quantity){

                        $newquantity = $quantity - $saledetail->quantity;
                        $amount         =   $quantity * $product->sale_price;

                        $total_amount   =   $total_amount - $saledetail->amount + $amount;

                        $saledetail->amount   = $amount;
                        $saledetail->quantity = $quantity;
                        $saledetail->save();

                        

                        $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity - $newquantity;
                        $stock->save();

                    }


                }


            }

            $number_row = Stock::where('branch_id',$sale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $rowcount; $i++) { 
                
                $add_product_id = request('add_product_id'.$i);
                $add_quantity = request('add_quantity'.$i);

                if ($add_quantity == !null) {
                    
                    $product = Product::where('id',$add_product_id)->first();
                    $amount = $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;

                    $saledetail = New Saledetail;
                    $saledetail->sale_id = $sale->id;
                    $saledetail->product_id = $add_product_id;
                    $saledetail->quantity = $add_quantity;
                    $saledetail->amount = $amount;
                    $saledetail->save();

                    $stock_check = Stock::where('branch_id',$sale->branch_id)->where('product_id',$add_product_id)->first();
                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();

                }

            }

            $update_sale = Sale::find($sale->id);
            $update_sale->customer_id = $customer_id;
            $update_sale->total_amount = $total_amount;
            $update_sale->bonus = $bonus;
            $update_sale->discount = $discount;
            $update_sale->saledate = $sale_date;

            $minus_discount     =   $total_amount * $discount / 100;
            // $minus_bonus        =   $total_amount - $bonus;
            $final_balance      =   $total_amount - $minus_discount - $bonus;
           
            $update_sale->balance      =   $final_balance;
            $update_sale->save();

            $promotiondetail = Promotiondetail::where('voucher_no',$sale->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail);

                for ($i=1; $i < $count ; $i++) { 
                    
                    $delete = request('promo_delete'.$i);
                    $promo_product = request('promo_product_id'.$i);
                    $promo_quantity = request('promo_quantity'.$i);

                    if ($delete == "Delete") {
                        
                        $promo_delete = Promotiondetail::where('voucher_no',$sale->voucher_no)->where('product_id',$promo_product)->first();

                        // dd($promo_product);

                        $stock_add = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$promo_product)->first();
                        $stock_add->quantity = $stock_add->quantity + $promo_delete->quantity;
                        $stock_add->save();

                        $promo_delete->delete();

                    }else{

                        $promotion = Promotiondetail::where('voucher_no',$sale->voucher_no)->where('product_id',$promo_product)->first();

                        if ($promotion->quantity < $promo_quantity) {
                            
                            $new_quantity = $promo_quantity - $promotion->quantity;

                            $stock_add = Stock::where('branch_id',$sale->branch_id)->where('product_id',$promo_product)->first();
                            $stock_add->quantity = $stock_add->quantity - $new_quantity;
                            $stock_add->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }elseif ($promotion->quantity > $promo_quantity) {
                            
                            $new_quantity = $promotion->quantity - $promo_quantity;
                            $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$promo_product)->first();
                            $stock->quantity = $stock->quantity + $new_quantity;
                            $stock->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }

                    }


                }

            }

            $number_row = Stock::where('branch_id',$sale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $number_row; $i++) { 
                
                $new_promo_product = request('add_promo_id'.$i);
                $new_promo_quantity = request('add_promo_quantity'.$i);

                if ($new_promo_quantity != Null) {
                    
                    $today = Carbon::now('Asia/Yangon');
                    $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

                    $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$new_promo_product)->first();
                    $stock->quantity = $stock->quantity - $new_promo_quantity;
                    $stock->save();

                    $promo_detail = new Promotiondetail;
                    $promo_detail->voucher_no = $sale->voucher_no;

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
            

        } //end credit mehtod

        return redirect()->route('sale_branch',$branch_id->branch_id)->with('successmsg','Voucher no- '.$voucher_no->voucher_no.' Successfully Update');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $creditsale = Creditsale::find($id);
        $branch_id = $creditsale->branch_id;
        $voucher_no = $creditsale->voucher_no;
        
        $creditsaledetail = Saledetail::where('sale_id',$id)->get();

        foreach ($creditsaledetail as $detail) {
            $add_stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$detail->product_id)->first();

            if ($add_stock == !null) {
                $add_stock->quantity = $add_stock->quantity + $detail->quantity ;

                if ($detail->sale_return == !null) {
                    
                    $add_stock->quantity = $add_stock->quantity - $detail->sale_return;

                }

                $add_stock->save();

            }else{

                $stock = New Stock;
                $stock->branch_id = $creditsale->branch_id;
                $stock->product_id = $detail->product_id;
                $stock->quantity = $detail->quantity;

                if ($detail->sale_return == !null) {
                    
                    $stock->quantity = $stock->quantity - $detail->sale_return;

                }

                $stock->save();
            }
        }

        $voucher_no = $creditsale->b_short."-".$creditsale->voucher_no;
        $promo_items = Promotiondetail::where('voucher_no',$voucher_no)->get();
        if (count($promo_items) > 0) {
            
            foreach ($promo_items as $item) {
                $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$item->product_id)->first();
                $items = Promotiondetail::where('voucher_no',$voucher_no)->where('product_id',$item->product_id)->first();
                if ($stock != null) {
                   $stock->quantity = $stock->quantity + $item->quantity;
                   $stock->save(); 
                }else{
                    $stock = New Stock;
                    $stock->branch_id = $creditsale->branch_id;
                    $stock->product_id = $item->product_id;
                    $stock->quantity = $item->quantity;
                    $stock->save();
                }
                $items->delete();
            }

        }

        $creditsale->status = "Deactive";
        $creditsale->save();

        return redirect()->route('sale_branch',$branch_id)->with('successmsg','Voucher_no = $voucher_no is Successfully Cancelled !!');

    }


    // sale return ------------------------------------------------------------

    public function credit_sale_return($id)
    {
        $credit_sale = Creditsale::find($id);
        $credit_saledetail = Creditsaledetail::where('creditsale_id',$id)->get();
        // dd($sale->branch_id);

        return view('backend.creditsales.credit_sale_return',compact('credit_sale','credit_saledetail'));
    }

    public function credit_return_update(Request $request, $id)
    {
        $request->validate([
            "return_date" => 'required'
        ]);

        $saledetail_num = Creditsaledetail::where('creditsale_id',$id)->get()->count();
        $count = $saledetail_num + 1;

        $sale_branch = Creditsale::find($id);

        $amount = [];
        $balance = 0;

        $total_amount = 0;




        for ($i=1; $i < $count; $i++) { 
            $branch_id = $sale_branch->branch_id;
            $return_date = request('return_date');
            $product_id = request('product_id'.$i);
            $return_quantity = request('return_quantity'.$i);
            $return_date = request('return_date');
           
            if ($return_quantity != null) {    
                $saledetail = Creditsaledetail::where('creditsale_id',$id)->where('product_id',$product_id)->first();
                $product = Product::where('id',$product_id)->first();
                if ($saledetail->sale_return == null) {

                    $different = $saledetail->quantity - $return_quantity;
                    $new_amount = $different * $product->sale_price;
                    $amount[] = $new_amount ; 

                    $saledetail->amount  = $new_amount;
                    $saledetail->sale_return = $return_quantity;
                    $saledetail->return_date = $return_date;
                    $saledetail->save();

                }else{
                    $total_return = $saledetail->sale_return + $return_quantity;
                    $saledetail->sale_return = $total_return;

                    $different = $saledetail->quantity - $total_return;
                    $new_amount = $different * $product->sale_price;
                    $amount[] = $new_amount ; 

                    $saledetail->amount  = $new_amount;
                    $saledetail->return_date = $return_date;

                    $saledetail->save();
                }

                

                $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                $stock->quantity = $stock->quantity + $return_quantity;
                $stock->save();
            }else{
                $saledetail = Creditsaledetail::where('creditsale_id',$id)->where('product_id',$product_id)->first();
                $amount[] = $saledetail->amount;
                // echo $saledetail->amount;
            }
        }


        foreach ($amount as $sum) {

            $total_amount +=$sum;

        }



        if ($sale_branch->bonus != null) {
            $balance = $total_amount - $sale_branch->bonus;
        }else{
            $balance = $total_amount;
        }

        // dd($balance);
        if ($sale_branch->discount != null) {
            $discount_amount = $balance * $sale_branch->discount / 100;
            $balance = $balance - $discount_amount;
        }

        $sale_branch->total_amount = $total_amount;
        $sale_branch->balance      = $balance;
        $sale_branch->save();

        return redirect()->route('sale_branch',$sale_branch->branch_id)->with('successmsg','Successfully Returned');
    }


}
