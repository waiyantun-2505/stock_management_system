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
use App\Promotion;
use App\Promotiondetail;


class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // $branch_sale = [];
        $branches = Branch::all();

        return view('backend.sales.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function sale_branch($id)
    {
        $branch = Branch::find($id);

        $sale = Sale::where('status','Active')->where('branch_id',$id)->orderBy('saledate','desc')->get();
        $credit_sale = Creditsale::where('status','Active')->where('branch_id',$id)->orderBy('saledate','desc')->get();

        // dd($credit_sale);


        $sale_cancel = Sale::where('status','Deactive')->where('branch_id',$id)->orderby('saledate','desc')->get();

        $creditsale_cancel = Creditsale::where('status','Deactive')->where('branch_id',$id)->orderby('saledate','desc')->get();


        return view('backend.sales.sale_branch',compact('sale','credit_sale','branch','sale_cancel','creditsale_cancel'));

    }

    public function create()
    {   
        $branches = Branch::all();

        return view('backend.sales.create',compact('branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function makesale($id)
    {

        $stock = Stock::where('branch_id',$id)->orderby('product_id','asc')->get();

        $product = Product::with('subcategory')->get();
        $branch = Branch::find($id);
        $customers = Customer::all();

        //check promotion

        $today = Carbon::now('Asia/Yangon');
        $promotion_status = Promotion::where('from','<',$today)->where('to','>',$today)->first();

        
        return view('backend.sales.makesale',compact('stock','branch','product','customers','promotion_status'));


    }

    public function preparesale(Request $request)
    {
        // dd(request('customer_name'));
        $request->validate([
            'customer_name' => 'required'
        ]);

        $customer = Customer::where('id',request('customer_name'))->first();
        $method = request('sale_method');
        $discount = request('discount');
        $bonus = request('bonus');
        $branch_id = request('branch_id');
        $branch = Branch::find($branch_id);
        

        $number_row = Stock::where('branch_id',$branch_id)->get();
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

        // dd($amount);


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
                $input_quantity = request('quantity'.$i);

                
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


        
        $sale_id = Sale::orderby('voucher_no','desc')->first();
        $test = Sale::select('voucher_no')->max('voucher_no');
        $creditsale_id = Creditsale::orderby('voucher_no','desc')->first();
        
        

        if ($branch_id == $branch->id) {

            $split = str_split($branch->name);
            $first_word = $split[0];

            $sale = Sale::where('b_short',$first_word)->orderBy('voucher_no','desc')->first();
            $creditsale = Creditsale::where('b_short',$first_word)->orderBy('voucher_no','desc')->first();

            if (empty($sale->voucher_no) && empty($creditsale->voucher_no)) {
            
                $branch = $first_word;
                $number = 1;
                $voucher_no = $branch.'-'.$number;
               

            }elseif (empty($sale->voucher_no)) {

                $branch = $first_word;
                $number = $creditsale->voucher_no + 1;
                $voucher_no = $branch.'-'.$number;

                

            }elseif (empty($creditsale->voucher_no)) {

                $branch = $first_word;
                $number = $sale->voucher_no + 1;
                $voucher_no = $branch.'-'.$number;

            }elseif ($creditsale->voucher_no > $sale->voucher_no) {

                $branch = $first_word;
                $number = $creditsale->voucher_no + 1;
                $voucher_no = $branch.'-'.$number;

            }elseif ($sale->voucher_no > $creditsale->voucher_no) {

                $branch = $first_word;
                $number = $sale->voucher_no + 1;
                $voucher_no = $branch.'-'.$number;

            }

        }
        
        

        $today_date = Carbon::today()->toDateString();

        return view('backend.sales.finalprint',compact('customer','method','discount','discount_amount','bonus','branch_id','product_id','product_name','quantity','amount','voucher_no','total_amount','balance','today_date','sale_price','promo_product_id','promo_quantity','promo_product_name'));
         


    }
    

    public function store(Request $request)
    {
        


        // ---------------------------------------------------------------------------

        $customer_id    = request('customer_id');
        $method         = request('method');
        $discount       = request('discount');
        $bonus          = request('bonus');
        $branch_id      = request('branch_id');
        $balance        = request('balance');
        $voucher_no     = request('voucher_no');

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

                $stock = Stock::where('product_id',$promo_product_id[$i])->where('branch_id',request('branch_id'))->first();
                $newquantity = $stock->quantity - $promo_quantity[$i];
                $stock->quantity = $newquantity;
                $stock->save();

            }
        }


        if ($method == "cash") {
            
            $count  = count($product_id);

            $sale = New Sale;
            $sale->b_short = $first;
            $sale->voucher_no   = $int;
            $sale->customer_id  = $customer_id;
            $sale->branch_id    = $branch_id;
            $sale->saledate     = Carbon::today()->toDateString();
            $sale->total_amount = $total_amount;
            $sale->discount     = $discount;
            $sale->bonus        = $bonus;

            
            $sale->balance      = $balance;
            $sale->status = "Active";
            $sale->save();

            for ($i=0; $i < $count; $i++) { 
                
                $saledetail             = New Saledetail;
                $saledetail->sale_id    = $sale->id;
                $saledetail->product_id = $product_id[$i];
                $saledetail->quantity   = $quantity[$i];
                $saledetail->amount     = $amount[$i];
                $saledetail->save();

                $stock = Stock::where('product_id',$product_id[$i])->where('branch_id',request('branch_id'))->first();
                $stock->quantity = $stock->quantity - $quantity[$i];
                $stock->save();

            }

        }else{

            
            $count  = count($product_id);

            $credit_sale = New Creditsale;
            $credit_sale->b_short = $first;
            $credit_sale->voucher_no   = $int;
            $credit_sale->customer_id  = $customer_id;
            $credit_sale->branch_id    = $branch_id;
            $credit_sale->saledate     = Carbon::today()->toDateString();
            $credit_sale->total_amount = $total_amount;
            $credit_sale->credit_method= $method;
            $credit_sale->discount     = $discount;
            $credit_sale->bonus        = $bonus;
            $credit_sale->balance      = $balance;
            $credit_sale->status       = "Active";
            $credit_sale->save();

            for ($i=0; $i < $count; $i++) { 
                
                $credit_saledetail                  = New Creditsaledetail;
                $credit_saledetail->creditsale_id   = $credit_sale->id;
                $credit_saledetail->product_id      = $product_id[$i];
                $credit_saledetail->quantity        = $quantity[$i];
                $credit_saledetail->amount          = $amount[$i];
                $credit_saledetail->save();

                $stock = Stock::where('product_id',$product_id[$i])->where('branch_id',request('branch_id'))->first();
                $stock->quantity = $stock->quantity - $quantity[$i];
                $stock->save();

            }

        }


        return redirect()->route('sale_branch',$branch_id)->with('successmsg','Successfully Make Sale');

 


        // ---------------------------------------------------------------------------




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $sales = Sale::find($id);

        $saledetail = Saledetail::where('sale_id',$id)->get();

        $promotion = Promotiondetail::where('voucher_no',$sales->voucher_no)->get();

        $sale_return = Saledetail::where('sale_id',$id)->where('sale_return','!=','Null')->get();



        return view('backend.sales.show',compact('sales','saledetail','promotion','sale_return'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::find($id);
        $saledetail = Saledetail::where('sale_id',$id)->get();
        $voucher_no = $sale->b_short.'-'.$sale->voucher_no;

        
        // dd($sale->branch_id);
        $stocks = Stock::where('branch_id',$sale->branch_id)->orderby('product_id','asc')->get();

        $promotiondetail = Promotiondetail::where('voucher_no',$voucher_no)->get();

        $product_id_arr = [];
        $promo_product_id_arr = [];    

        foreach ($stocks as $stock) {
            foreach ($saledetail as $detail) {
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



        $promo_arr = Stock::where('branch_id',$sale->branch_id)->wherenotIn('product_id',$promo_product_id_arr)->orderby('product_id','asc')->get();

        $stock_arr = Stock::where('branch_id',$sale->branch_id)->whereNotIn('product_id',$product_id_arr)->orderBy('product_id','asc')->get();

        // dd($promo_arr);
        // dd($promo_arr);
        $product = Product::with('subcategory')->get();
        $customers = Customer::all();

        //promotion_information

        $today = Carbon::now('Asia/Yangon'); 

        $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

        // dd($promotion);

        return view('backend.sales.edit',compact('sale','customers','saledetail','stocks','product','stock_arr','promo_arr','promotiondetail','promotion'));
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
        $branch_id      =   Sale::select('branch_id')->where('id',$id)->first();
        $voucher_no     =   Sale::select('voucher_no')->where('id',$id)->first();
        $discount       =   request('discount');
        $sale_method    =   request('sale_method');
        $sale_date      =   request('date');


        // for cash method
        if ($sale_method == "cash") {
            
            $detailrecords = Saledetail::where('sale_id',$id)->get()->count();
            $num_row = $detailrecords + 1;
            $sale   = Sale::find($id);
            $total_amount = $sale->total_amount;

            for ($i=1; $i < $num_row; $i++) { 
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {

                    $saledetail_delete = Saledetail::where('sale_id',$id)->where('product_id',$product_id)->first();

                    $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$product_id)->first();
                    // dd($saledetail_delete->sale_return);
                    if (isset($saledetail_delete->sale_return)) {    
                        $new_quantity = $saledetail_delete->quantity - $saledetail_delete->sale_return;
                        // dd($new_quantity);
                    }else{
                        $new_quantity = $saledetail_delete->quantity;
                    }

                    $stock->quantity = $stock->quantity + $new_quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $saledetail_delete->amount;

                    $saledetail_delete->delete();

                }else{

                    $saledetail = Saledetail::where('sale_id',$id)->where('product_id',$product_id)->first();
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

                        

                        $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$product_id)->first();
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

            // echo $total_amount."<br>";

            $number_row = Stock::where('branch_id',$sale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            // dd($number_row);

            // add new product

            for ($j=1; $j < $rowcount; $j++) { 
                $add_product_id = request('add_product_id'.$j);
                $add_quantity = request('add_quantity'.$j);
                

                if ($add_quantity == !null) {
                    $product    = Product::where('id',$add_product_id)->first();
                    $amount     =   $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;


                    $saledetail = new Saledetail;
                    $saledetail->sale_id = $id;
                    $saledetail->product_id = $add_product_id;
                    $saledetail->quantity = $add_quantity;
                    $saledetail->amount   = $amount;
                    $saledetail->save();

                    $stock_check = Stock::where('branch_id',$sale->branch_id)->where('product_id',$add_product_id)->first();
                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();
                    
                        
                    
                }

            }
            //end of adding new product

            $sale->customer_id  = $customer_id;
            $sale->total_amount = $total_amount;
            $sale->bonus        = $bonus;
            $sale->discount     = $discount;
            $sale->saledate     =   $sale_date;

            
            $minus_discount     =   $total_amount * $discount / 100;
            // $minus_bonus        =   $total_amount - $bonus;
            $final_balance      =   $total_amount - $minus_discount - $bonus;
           
            $sale->balance      =   $final_balance;
            $sale->save();

            //promotion stage

            $promotiondetail = Promotiondetail::where('voucher_no',$sale->b_short.'-'.$sale->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail);
                
                for ($i=1; $i <= $count ; $i++) { 
                    
                    $delete = request('promo_delete'.$i);
                    $promo_product = request('promo_product_id'.$i);
                    $promo_quantity = request('promo_quantity'.$i);

                    if ($delete == "Delete") {
                        
                        $promo_delete = Promotiondetail::where('voucher_no',$sale->b_short.'-'.$sale->voucher_no)->where('product_id',$promo_product)->first();


                        $stock_add = Stock::where('branch_id',$sale->branch_id)->where('product_id',$promo_product)->first();
                        $stock_add->quantity = $stock_add->quantity + $promo_delete->quantity;
                        $stock_add->save();

                        $promo_delete->delete();


                    }else{
                        $promotion = Promotiondetail::where('voucher_no',$sale->b_short.'-'.$sale->voucher_no)->where('product_id',$promo_product)->first();
                        // dd($promotion);
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


                }  // For loop end

            } // have promotion if end

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
                    $promo_detail->voucher_no = $sale->b_short.'-'.$sale->voucher_no;

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



        }

        // for end cash mehtod

        //start credit method ================================================================

        if ($sale_method == "credit" || $sale_method == "1week" || $sale_method == "2week") {
            
            $detailrecords = Saledetail::where('sale_id',$id)->get();
            $num_row = count($detailrecords) + 1;
            $sale   = Sale::find($id);

            $credit_sale = New Creditsale;
            $credit_sale->b_short = $sale->b_short;
            $credit_sale->voucher_no = $sale->voucher_no;
            $credit_sale->customer_id = $sale->customer_id;
            $credit_sale->branch_id = $sale->branch_id;
            $credit_sale->saledate = $sale->saledate;
            $credit_sale->credit_method = $sale_method;
            $credit_sale->total_amount = $sale->total_amount;
            $credit_sale->discount = $sale->discount;
            $credit_sale->bonus = $sale->bonus;
            $credit_sale->balance = $sale->balance;
            $credit_sale->status = "Active";
            $credit_sale->save();

            foreach ($detailrecords as $sale_detail) {

                $credit_saledetail = New Creditsaledetail;
                $credit_saledetail->creditsale_id = $credit_sale->id;
                $credit_saledetail->product_id = $sale_detail->product_id;
                $credit_saledetail->sale_return = $sale_detail->sale_return;
                $credit_saledetail->return_date = $sale_detail->return_date;
                $credit_saledetail->quantity    = $sale_detail->quantity;
                $credit_saledetail->amount      = $sale_detail->amount;
                $credit_saledetail->save();

            }

            $sale->delete();

            
            $credit_count = Creditsaledetail::where('creditsale_id',$credit_sale->id )->get()->count();
            $num_row = $credit_count + 1;
            $total_amount = $credit_sale->total_amount;

            for ($i=1; $i < $num_row ; $i++) { 
                
                $delete     = request('delete'.$i);
                $product_id = request('product_id'.$i);
                $quantity   = request('quantity'.$i);

                if ($delete == "Delete") {
                    
                    $creditdetail_delete = Creditsaledetail::where('creditsale_id',$credit_sale->id)->where('product_id',$product_id)->first();

                    $stock = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$product_id)->first();

                    $stock->quantity = $stock->quantity + $creditdetail_delete->quantity;
                    $stock->save();

                    $total_amount = $total_amount   -   $creditdetail_delete->amount;

                    $creditdetail_delete->delete();

                }else{

                    $creditdetail = Creditsaledetail::where('creditsale_id',$credit_sale->id)->where('product_id',$product_id)->first();
                    $product    = Product::where('id',$product_id)->first();

                    if ($quantity < $creditdetail->quantity) {
                        
                        $newquantity = $creditdetail->quantity - $quantity;
                        $amount = $quantity * $product->sale_price;

                        $total_amount = $total_amount - $creditdetail->amount + $amount;

                        $creditdetail->amount = $amount;
                        $creditdetail->quantity = $quantity;
                        $creditdetail->save();

                        $stock = Stock::where('branch_id',$credit_sale->id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity + $newquantity;
                        $stock->save();

                    }elseif($quantity > $creditdetail->quantity){

                        $newquantity = $quantity - $creditdetail->quantity;
                        $amount         =   $quantity * $product->sale_price;

                        $total_amount   =   $total_amount - $creditdetail->amount + $amount;

                        $creditdetail->amount   = $amount;
                        $creditdetail->quantity = $quantity;
                        $creditdetail->save();

                        

                        $stock = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity - $newquantity;
                        $stock->save();

                    }


                }


            }

            $number_row = Stock::where('branch_id',$credit_sale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $rowcount; $i++) { 
                
                $add_product_id = request('add_product_id'.$i);
                $add_quantity = request('add_quantity'.$i);

                if ($add_quantity == !null) {
                    
                    $product = Product::where('id',$add_product_id)->first();
                    $amount = $add_quantity * $product->sale_price;
                    $total_amount = $total_amount + $amount;

                    $creditdetail = New Creditsaledetail;
                    $creditdetail->creditsale_id = $credit_sale->id;
                    $creditdetail->product_id = $add_product_id;
                    $creditdetail->quantity = $add_quantity;
                    $creditdetail->amount = $amount;
                    $creditdetail->save();

                    $stock_check = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$add_product_id)->first();
                    $stock_check->quantity = $stock_check->quantity - $add_quantity;
                    $stock_check->save();

                }

            }

            $update_creditsale = Creditsale::find($credit_sale->id);
            $update_creditsale->customer_id = $customer_id;
            $update_creditsale->total_amount = $total_amount;
            $update_creditsale->bonus = $bonus;
            $update_creditsale->discount = $discount;
            $update_creditsale->saledate = $sale_date;
            $update_creditsale->credit_method =  $sale_method;

            $minus_discount     =   $total_amount * $discount / 100;
            // $minus_bonus        =   $total_amount - $bonus;
            $final_balance      =   $total_amount - $minus_discount - $bonus;
           
            $update_creditsale->balance      =   $final_balance;
            $update_creditsale->save();

            $promotiondetail = Promotiondetail::where('voucher_no',$credit_sale->b_short.'-'.$credit_sale->voucher_no)->get();

            if (count($promotiondetail) > 0) {
                
                $count = count($promotiondetail);

                for ($i=1; $i < $count ; $i++) { 
                    
                    $delete = request('promo_delete'.$i);
                    $promo_product = request('promo_product_id'.$i);
                    $promo_quantity = request('promo_quantity'.$i);

                    if ($delete == "Delete") {
                        
                        $promo_delete = Promotiondetail::where('voucher_no',$credit_sale->b_short.'-'.$credit_sale->voucher_no)->where('product_id',$promo_product)->first();

                        // dd($promo_product);

                        $stock_add = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$promo_product)->first();
                        $stock_add->quantity = $stock_add->quantity + $promo_delete->quantity;
                        $stock_add->save();

                        $promo_delete->delete();

                    }else{

                        $promotion = Promotiondetail::where('voucher_no',$credit_sale->b_short.'-'.$credit_sale->voucher_no)->where('product_id',$promo_product)->first();

                        if ($promotion->quantity < $promo_quantity) {
                            
                            $new_quantity = $promo_quantity - $promotion->quantity;

                            $stock_add = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$promo_product)->first();
                            $stock_add->quantity = $stock_add->quantity - $new_quantity;
                            $stock_add->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }elseif ($promotion->quantity > $promo_quantity) {
                            
                            $new_quantity = $promotion->quantity - $promo_quantity;
                            $stock = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$promo_product)->first();
                            $stock->quantity = $stock->quantity + $new_quantity;
                            $stock->save();

                            $promotion->quantity = $promo_quantity;
                            $promotion->save();

                        }

                    }


                }

            }

            $number_row = Stock::where('branch_id',$credit_sale->branch_id)->get()->count();
            $rowcount = $number_row + 1;

            for ($i=1; $i < $number_row; $i++) { 
                
                $new_promo_product = request('add_promo_id'.$i);
                $new_promo_quantity = request('add_promo_quantity'.$i);

                if ($new_promo_quantity != Null) {
                    
                    $today = Carbon::now('Asia/Yangon');
                    $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

                    $stock = Stock::where('branch_id',$credit_sale->branch_id)->where('product_id',$new_promo_product)->first();
                    $stock->quantity = $stock->quantity - $new_promo_quantity;
                    $stock->save();

                    $promo_detail = new Promotiondetail;
                    $promo_detail->voucher_no = $credit_sale->voucher_no;

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

        // dd($branch_id);
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
        $sale = Sale::find($id);
        $branch_id = $sale->branch_id;
        $voucher_no = $sale->voucher_no;
        
        $saledetail = Saledetail::where('sale_id',$id)->get();

        foreach ($saledetail as $detail) {
            $add_stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$detail->product_id)->first();

            if ($add_stock == !null) {
                $add_stock->quantity = $add_stock->quantity + $detail->quantity ;

                if ($detail->sale_return == !null) {
                    
                    $add_stock->quantity = $add_stock->quantity - $detail->sale_return;

                }

                $add_stock->save();

            }else{

                $stock = New Stock;
                $stock->branch_id = $sale->branch_id;
                $stock->product_id = $detail->product_id;
                $stock->quantity = $detail->quantity;

                if ($detail->sale_return == !null) {
                    
                    $stock->quantity = $stock->quantity - $detail->sale_return;

                }

                $stock->save();
            }
        }

        $voucher_no = $sale->b_short."-".$sale->voucher_no;

        $promo_items = Promotiondetail::where('voucher_no',$voucher_no)->get();
        if (count($promo_items) > 0) {
            
            foreach ($promo_items as $item) {
                $product_id = $item->product_id;
                $stock = Stock::where('branch_id',$sale->branch_id)->where('product_id',$item->product_id)->first();
                $items = Promotiondetail::where('voucher_no',$voucher_no)->where('product_id',$product_id)->first();
                 
                if ($stock != null) {
                   $stock->quantity = $stock->quantity + $item->quantity;
                   $stock->save(); 
                }else{
                    $stock = New Stock;
                    $stock->branch_id = $sale->branch_id;
                    $stock->product_id = $item->product_id;
                    $stock->quantity = $item->quantity;
                    $stock->save();
                }
                $items->delete();
            }

        }

        $sale->status = "Deactive";
        $sale->save();

        return redirect()->route('sale_branch',$branch_id)->with('successmsg','Voucher_no = $voucher_no is Successfully Cancelled !!');


    }   

    public function sale_return($id)
    {
        $sale = Sale::find($id);
        $saledetail = Saledetail::where('sale_id',$id)->get();
        // dd($sale->branch_id);

        return view('backend.sales.sale_return',compact('sale','saledetail'));
    }

    public function return_update(Request $request, $id)
    {
        $request->validate([
            "return_date" => 'required'
        ]);

        $saledetail_num = Saledetail::where('sale_id',$id)->get()->count();
        $count = $saledetail_num + 1;

        $sale_branch = Sale::find($id);

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
                
                $saledetail = Saledetail::where('sale_id',$id)->where('product_id',$product_id)->first();
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
                $saledetail = Saledetail::where('sale_id',$id)->where('product_id',$product_id)->first();
                $amount[] = $saledetail->amount;
                // echo $saledetail->amount;
            }
        }


        foreach ($amount as $sum) {

            $total_amount +=$sum;

        }



        

        // dd($balance);
        if ($sale_branch->discount != null) {
            $discount_amount = $total_amount * $sale_branch->discount / 100;
            $balance = $total_amount - $discount_amount;
        }else{
            $balance = $total_amount;
        }

        if ($sale_branch->bonus != null) {
            $balance = $balance - $sale_branch->bonus;
        }else{
            $balance = $balance;
        }

        $sale_branch->total_amount = $total_amount;
        $sale_branch->balance      = $balance;
        $sale_branch->save();

        return redirect()->route('sale_branch',$sale_branch->branch_id)->with('successmsg','Successfully Returned');

    }
}
