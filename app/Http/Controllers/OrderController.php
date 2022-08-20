<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Category;
use App\Subcategory;
use App\Product;
use App\Stock;
use App\Orderdetail;
use App\Branch;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status','Active')->orderby('orderdate','desc')->get();

        $order_cancel = Order::where('status','Deactive')->orderby('id','desc')->get();

        return view('backend.orders.index',compact('orders','order_cancel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $products = Product::with('stocks')->orderby('subcategory_id','asc')->get();
        $stocks = Stock::all();
        $branches = Branch::all();
        // dd($products);
        return view('backend.orders.create',compact('categories','subcategories','products','stocks','branches'));
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
            "name" =>'required',
            "branch_id" => 'required'
        ]);

        //to save order table
        $order = new Order;
        $order->suppliername = request('name');
        $order->orderdate = Carbon::today()->toDateString();
        $order->status  = "Active";
        $order->save();

        //to count row of products

        $number_row = Product::all();
        $rowcount = $number_row->count() + 1; 


        for( $i=1 ; $i<$rowcount; $i++ )
        {   
            
            $productid = request("add_product_id".$i); //recieve product_id from view
            $first_quantity = request("first_quantity".$i);     //recieve quantity from view
            $second_quantity = request("second_quantity".$i);     //recieve quantity from view
            // dd($productid);
            // dd($first_quantity);

            $first_branch = request("branch_id");
            $second_branch = request("branch_id2");
            // dd($productid_arr);

            if ($first_branch == !null && $first_quantity == !null) 
            {
                $first_b_stock = Stock::where('branch_id',$first_branch)->where('product_id',$productid)->first();
                // dd($first_b_stock);  
                
                if ($first_b_stock == null)  //if table is not have row
                {
                    $stock = new Stock;
                    $stock->product_id = $productid;
                    $stock->branch_id = $first_branch;
                    $stock->quantity = $first_quantity;
                    $stock->save();
                }

                if ($first_b_stock != null) 
                {   
                    $current_quantity = $first_b_stock->quantity;
                    $update_quantity = $current_quantity + $first_quantity;

                    $stock = Stock::find($first_b_stock->id);
                    $stock->quantity = $update_quantity;

                    $stock->save();
                }

                $orderdetail = new Orderdetail;
                $orderdetail->order_id = $order->id;
                $orderdetail->product_id = $productid;
                $orderdetail->branch_id = $first_branch;
                $orderdetail->quantity = $first_quantity;
                $orderdetail->save();

            }               //first Branch's endif

             if ($second_branch == !null && $second_quantity == !null) 
            {
                $second_b_stock = Stock::where('branch_id',$second_branch)->where('product_id',$productid)->first();
                // dd($first_b_stock);  
                
                if ($second_b_stock == null)  //if table is not have row
                {
                    $stock = new Stock;
                    $stock->product_id = $productid;
                    $stock->branch_id = $second_branch;
                    $stock->quantity = $second_quantity;
                    $stock->save();
                }

                if ($second_b_stock != null) 
                {   
                    $current_quantity = $second_b_stock->quantity;
                    $update_quantity = $current_quantity + $second_quantity;

                    $stock = Stock::find($second_b_stock->id);
                    $stock->quantity = $update_quantity;

                    $stock->save();
                }

                $orderdetail = new Orderdetail;
                $orderdetail->order_id = $order->id;
                $orderdetail->product_id = $productid;
                $orderdetail->branch_id = $second_branch;
                $orderdetail->quantity = $second_quantity;
                $orderdetail->save();

            }               //first Branch's if

            
        }
            

        return redirect()->route('orders.index')->with('successmsg','Successfully Ordered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   

        $categories = Category::all();
        $subcategories = Subcategory::all();
        $products = Product::with('stocks')->orderby('subcategory_id','asc')->get();
        $stocks = Stock::all();
        $all_branch = Branch::all();
        
        $order = Order::find($id);
        $orderdetails = Orderdetail::where('order_id',$id)->get();
        $branches = Orderdetail::where('order_id',$id)->select('branch_id')->distinct('branch_id')->orderBy('branch_id','asc')->get();
        // dd($orderdetail);
        return view('backend.orders.edit',compact('order','branches','orderdetails','categories','subcategories','products','stocks','all_branch'));
        
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
            "name" => 'required',
            "date" => 'required'
        ]);

        $order = Order::find($id);
        $order->suppliername = request('name');
        $order->orderdate = request('date');
        $order->save();

        $detailrecords = Orderdetail::where('order_id',$id)->get()->count();
        $num_row = $detailrecords + 1;

        for ($i=1; $i < $num_row ; $i++) { 

            $delete = request('delete'.$i);
            $branch_id = request('branch'.$i);
            $product_id = request('product_id'.$i);
            $quantity = request('quantity'.$i);
            // dd($branch_id);

            if ($delete == 'Delete') {

                $orderdetail_delete = Orderdetail::where('order_id',$id)->where('branch_id',$branch_id)->where('product_id',$product_id)->first();

                $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                $stock->quantity = $stock->quantity - $orderdetail_delete->quantity;
                $stock->save();

                
                $orderdetail_delete->delete();           

            }else{

                $orderdetail = Orderdetail::where('order_id',$id)->where('branch_id',$branch_id)->where('product_id',$product_id)->first();


                if ($quantity < $orderdetail->quantity) {
                    
                    $newquantity = $orderdetail->quantity - $quantity;

                    $orderdetail->quantity =  $quantity;
                    $orderdetail->save();



                    $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                    $stock->quantity = $stock->quantity - $newquantity;
                    $stock->save();

                }elseif ($quantity > $orderdetail->quantity) {
                    
                    $newquantity = $quantity - $orderdetail->quantity;

                    $orderdetail->quantity = $quantity;
                    $orderdetail->save();



                    $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                    $stock->quantity = $stock->quantity + $newquantity;
                    $stock->save();

                }

            }

            
        }  //end of for loop

        // ----------------- upper table complete-----------------------

        $number_row = Product::all();
        $rowcount = $number_row->count() + 1; 


        for( $i=1 ; $i<$rowcount; $i++ )
        {   
            
            $productid = request("add_product_id".$i); //recieve product_id from view
            $first_quantity = request("first_quantity".$i);     //recieve quantity from view
            $second_quantity = request("second_quantity".$i);     //recieve quantity from view

            // dd($first_branch);

            $first_branch = request("add_branch_id");
            $second_branch = request("add_branch_id2");
            // dd($second_branch);

            if ($first_branch == !null && $first_quantity == !null) 
            {
                $first_b_stock = Stock::where('branch_id',$first_branch)->where('product_id',$productid)->first();
                // dd($first_b_stock);  
                
                if ($first_b_stock == null)  //if table is not have row
                {
                    $stock = new Stock;
                    $stock->product_id = $productid;
                    $stock->branch_id = $first_branch;
                    $stock->quantity = $first_quantity;
                    $stock->save();
                }

                if ($first_b_stock != null) 
                {   
                    $current_quantity = $first_b_stock->quantity;
                    $update_quantity = $current_quantity + $first_quantity;

                    $stock = Stock::find($first_b_stock->id);
                    $stock->quantity = $update_quantity;

                    $stock->save();
                }

                $orderdetail_check = Orderdetail::where('order_id',$id)->where('branch_id',$first_branch)->where('product_id',$productid)->first();
                // dd($orderdetail_check);

                if ($orderdetail_check == null) {

                    $orderdetail = new Orderdetail;
                    $orderdetail->order_id = $id;
                    $orderdetail->product_id = $productid;
                    $orderdetail->branch_id = $first_branch;
                    $orderdetail->quantity = $first_quantity;
                    $orderdetail->save();

                }else{

                    $orderdetail_check->quantity = $orderdetail_check->quantity + $first_quantity;
                    $orderdetail_check->save();

                }
                

            }               //first Branch's endif

             if ($second_branch == !null && $second_quantity == !null) 
            {
                $second_b_stock = Stock::where('branch_id',$second_branch)->where('product_id',$productid)->first();
                // dd($first_b_stock);  
                
                if ($second_b_stock == null)  //if table is not have row
                {
                    $stock = new Stock;
                    $stock->product_id = $productid;
                    $stock->branch_id = $second_branch;
                    $stock->quantity = $second_quantity;
                    $stock->save();
                }

                if ($second_b_stock != null) 
                {   
                    $current_quantity = $second_b_stock->quantity;
                    $update_quantity = $current_quantity + $second_quantity;

                    $stock = Stock::find($second_b_stock->id);
                    $stock->quantity = $update_quantity;

                    $stock->save();
                }

                $orderdetail_check = Orderdetail::where('order_id',$id)->where('branch_id',$second_branch)->where('product_id',$productid)->first();
                // dd($orderdetail_check);

                if ($orderdetail_check == null) {

                    $orderdetail = new Orderdetail;
                    $orderdetail->order_id = $id;
                    $orderdetail->product_id = $productid;
                    $orderdetail->branch_id = $second_branch;
                    $orderdetail->quantity = $second_quantity;
                    $orderdetail->save();

                }else{

                    $orderdetail_check->quantity = $orderdetail_check->quantity + $second_quantity;
                    $orderdetail_check->save();

                }

            }               //first Branch's if

            
        }
        
        return redirect()->route('orders.index')->with('successmsg','Successfully Updated!!');;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        $num_branch = Orderdetail::select('branch_id')->where('order_id',$id)->distinct('branch_id')->get();

        // dd($num_branch);
        foreach ($num_branch as $branch) {
            $orderdetail = Orderdetail::where('order_id',$id)->where('branch_id',$branch->branch_id)->get();
            // dd($orderdetail);
            
            foreach ($orderdetail as $detail) {
                $stock_branch = Stock::where('branch_id',$branch->branch_id)->where('product_id',$detail->product_id)->first();

                if ($detail->order_return != null) {
                    
                    $new_quantity = $detail->quantity - $detail->order_return;

                    
                    

                    $stock_branch->quantity = $stock_branch->quantity - $new_quantity;
                    $stock_branch->save();

                    

                }else{
                    $stock_branch->quantity = $stock_branch->quantity - $detail->quantity;
                    $stock_branch->save();
                }




            }
        } 

        // dd($orderdetail);
        
        $order->status = "Deactive";
        $order->save();

        return redirect()->route('orders.index')->with('successmsg','Successfully Deleted');

    }

    public function order_return($id)
    {   

        
        
        $order = Order::find($id);
        $orderdetails = Orderdetail::where('order_id',$id)->get();
        $branches = Orderdetail::where('order_id',$id)->select('branch_id')->distinct('branch_id')->orderBy('branch_id','asc')->get();
        // dd($orderdetail);
        return view('backend.orders.order_return',compact('order','branches','orderdetails'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function return_update(Request $request, $id)
    {
        $request->validate([
            "return_date" => 'required'
        ]);

        // dd($id);

        $orderdetail_count = Orderdetail::where('order_id',$id)->get()->count();
        $count = $orderdetail_count + 1;

        for ($i=1; $i < $count ; $i++) { 
            $branch_id = request('branch'.$i);
            $product_id = request('product_id'.$i);
            $quantity = request('return_quantity'.$i);
            $return_date = request('return_date');
        
            

            if ($quantity == !null) {

                
                $orderdetail = Orderdetail::where('order_id',$id)->where('product_id',$product_id)->where('branch_id',$branch_id)->first();

                if ($orderdetail->order_return != null) {
                    
                    if ($quantity < $orderdetail->order_return) {

                        $new_quantity = $orderdetail->order_return - $quantity;

                        $orderdetail->order_return = $quantity;
                        $orderdetail->save();

                        $order = Order::find($id);
                        $order->return_date = $return_date;
                        $order->save();

                        $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity + $new_quantity;
                        $stock->save();

                    }elseif ($quantity > $orderdetail->order_return) {
                        
                        $new_quantity = $quantity - $orderdetail->order_return;

                        $orderdetail->order_return = $quantity;
                        $orderdetail->save();

                        $order = Order::find($id);
                        $order->return_date = $return_date;
                        $order->save();

                        $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                        $stock->quantity = $stock->quantity - $new_quantity;
                        $stock->save();

                    }

                }else{

                    $orderdetail->order_return = $quantity;
                    $orderdetail->save();

                    $order = Order::find($id);
                    $order->return_date = $return_date;
                    $order->save();

                    $stock = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                    $stock->quantity = $stock->quantity - $quantity;
                    $stock->save();

                }


                

            }
        }

        return redirect()->route('orders.index')->with('successmsg','Successfully Returned');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

}
