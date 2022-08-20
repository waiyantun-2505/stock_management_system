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


class WaycreditsaleController extends Controller
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
        $waysale_detail = Waycreditsale::with('Waycreditsaledetails')->find($id);

        $promotion = Promotiondetail::where('voucher_no',$waysale_detail->b_short."-".$waysale_detail->voucher_no)->with('product')->get();

        return view('backend.waycreditsales.show',compact('waysale_detail','promotion'));
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

        $waysale_details = Waycreditsale::with('Waycreditsaledetails')->find($id);

        $promotions = Promotiondetail::where('voucher_no',$waysale_details->b_short."-".$waysale_details->voucher_no)->with('product')->get();

        $way_stock = Wayout::with('wayoutdetails')->find($waysale_details->wayout_id);
        // dd($way_stock);
        $product_id_arr = [];
        $promo_product_id_arr = [];


        foreach ($way_stock->wayoutdetails as $stock) {
            foreach ($waysale_details->waycreditsaledetails as $detail) {
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

        return view('backend.waycreditsales.edit',compact('way_stock','waysale_details','promotion','promotions','customers','promo_arr','stock_arr'));
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
        $voucher_no     =   Waycreditsale::select('b_short','voucher_no')->where('id',$id)->first();
        $discount       =   request('discount');
        $sale_method    =   request('sale_method');
        $sale_date      =   request('date');

        // dd($sale_method);

        if ($sale_method == "credit" || $sale_method == "1week" || $sale_method == "2week") {
            
            $detailrecords = Waycreditsaledetail::where('waycreditsale_id',$id)->get()->count();
            $num_row = $detailrecords + 1;
            $creditsale   = Waycreditsale::find($id);
            $total_amount = $creditsale->total_amount;

            for ($i=1; $i < $num_row ; $i++) { 
                
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {
                    
                    $credit_detail_delete = Waycreditsaledetail::where('waycreditsale_id',$id)->where('product_id',$product_id)->first();

                    $stock = Stock::where('branch_id',$creditsale->branch_id)->where('product_id',$product_id)->first();
                    $stock->quantity = $stock->quantity + $credit_detail_delete->quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $credit_detail_delete->amount;

                    $credit_detail_delete->delete();

                }else{ 

                    $credit_saledetail = Waycreditsaledetail::where('waycreditsale_id',$id)->where('product_id',$product_id)->first();
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
            
            $detailrecords = Waycreditsaledetail::where('waycreditsale_id',$id)->get();
            $num_row = count($detailrecords) + 1;
            $credit_sale   = Waycreditsale::find($id);

            $sale = New Waysale;
            $sale->voucher_no = $credit_sale->voucher_no;
            $sale->b_short = $credit_sale->b_short;
            $sale->wayout_id = $credit_sale->wayout_id;
            $sale->customer_id = $credit_sale->customer_id;
            $sale->waysale_date = $credit_sale->waysale_date;
            $sale->total_amount = $credit_sale->total_amount;
            $sale->discount = $credit_sale->discount;
            $sale->bonus = $credit_sale->bonus;
            $sale->balance = $credit_sale->balance;
            $sale->status = "Active";
            $sale->save();

            foreach ($detailrecords as $creditsale_detail) {

                $saledetail = New Waysaledetail;
                $saledetail->waysale_id = $sale->id;
                $saledetail->product_id = $creditsale_detail->product_id;
                $saledetail->quantity    = $creditsale_detail->quantity;
                $saledetail->amount      = $creditsale_detail->amount;
                $saledetail->save();

            }

            $credit_sale->delete();

            
            $saledetail_count = Waysaledetail::where('waysale_id',$sale->id )->get()->count();
            $num_row = $saledetail_count + 1;
            $total_amount = $sale->total_amount;

            //if Delete Button conditions else change quantity
            for ($i=1; $i < $num_row ; $i++) { 
                
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {
                    
                    $saledetail_delete = Waysaledetail::where('waysale_id',$sale->id)->where('product_id',$product_id)->first();

                    $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();

                    $stock->quantity = $stock->quantity + $saledetail_delete->quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $saledetail_delete->amount;

                    $saledetail_delete->delete();

                }else{

                    $saledetail = Waysaledetail::where('waysale_id',$sale->id)->where('product_id',$product_id)->first();
                    $product    = Product::where('id',$product_id)->first();

                    if ($quantity < $saledetail->quantity) {
                        
                        $newquantity = $saledetail->quantity - $quantity;
                        $amount = $quantity * $product->sale_price;

                        $total_amount = $total_amount - $saledetail->amount + $amount;

                        $saledetail->amount = $amount;
                        $saledetail->quantity = $quantity;
                        $saledetail->save();

                        $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity + $newquantity;
                        $stock->save();

                    }elseif($quantity > $saledetail->quantity){

                        $newquantity = $quantity - $saledetail->quantity;
                        $amount         =   $quantity * $product->sale_price;

                        $total_amount   =   $total_amount - $saledetail->amount + $amount;

                        $saledetail->amount   = $amount;
                        $saledetail->quantity = $quantity;
                        $saledetail->save();

                        

                        $stock = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity - $newquantity;
                        $stock->save();

                    }


                }


            }

            $number_row = Wayoutdetail::where('wayout_id',$sale->wayout_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $rowcount; $i++) { 
                
                $add_product_id = request('add_product_id'.$i);
                $add_quantity = request('add_quantity'.$i);

                if ($add_quantity == !null) {
                    
                    $product = Product::where('id',$add_product_id)->first();
                    $amount = $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;

                    $saledetail = New Waysaledetail;
                    $saledetail->waysale_id = $sale->id;
                    $saledetail->product_id = $add_product_id;
                    $saledetail->quantity = $add_quantity;
                    $saledetail->amount = $amount;
                    $saledetail->save();

                    $stock_check = Wayoutdetail::where('wayout_id',$sale->wayout_id)->where('product_id',$add_product_id)->first();
                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();

                }

            }

            $update_sale = Waysale::find($sale->id);
            $update_sale->customer_id = $customer_id;
            $update_sale->total_amount = $total_amount;
            $update_sale->bonus = $bonus;
            $update_sale->discount = $discount;
            $update_sale->waysale_date = $sale_date;

            $minus_discount     =   $total_amount * $discount / 100;
            // $minus_bonus        =   $total_amount - $bonus;
            $final_balance      =   $total_amount - $minus_discount - $bonus;
           
            $update_sale->balance      =   $final_balance;
            $update_sale->save();

            $promotiondetail = Promotiondetail::where('voucher_no',$voucher_no->b_short."-".$voucher_no->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail)+1;

                for ($i=1; $i < $count ; $i++) { 
                    
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
        
        $waysale = Waycreditsale::find($id);
        
        $waysaledetail = Waycreditsaledetail::where('waycreditsale_id',$id)->get();

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
}
