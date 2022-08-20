<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Subcategory;
use App\Stock;
use App\Branch;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $stocks = Stock::all();
        return view('backend.products.index',compact('products','stocks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcategories = Subcategory::all();
        $branches = Branch::all();
        return view('backend.products.create',compact('subcategories','branches'));
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
            'name'              => 'required',
            'subcategoryname'   => 'required',
            'order_price'       => 'required',
            'sale_price'        => 'required'
        ]);

        $product_id = Product::orderby('id','desc')->first();
        // $id = $product_id->id + 1;
        // dd($product_id);

        $product = new Product;
        $product->name = request('name');
        

        if (empty($product_id->id)) {
            $product->code_no = "P0001";
        }else{
            $id = $product_id->id + 1;
            if (strlen($product_id->id) < 2) {
            $product->code_no = "P000".$id;
                if ($id == 10) {
                    $product->code_no = "P0010";
                }

            }elseif(strlen($product_id->id) < 3){
                $product->code_no = "P00".$id;
                if ($id == 100) {
                    $product->code_no = "P0100";
                }
            }elseif(strlen($product_id->id) < 4){
                $product->code_no = "P0".$id;
                if ($id == 1000) {
                    $product->code_no = "P1000";
                }
            }elseif(strlen($product_id->id) < 5){
                $product->code_no = "P".$id;
                
            }
        }

        // $product->code_no = "P0002";
        $product->order_price = request('order_price');
        $product->sale_price = request('sale_price');
        $product->subcategory_id = request('subcategoryname');

        $product->save();


        return redirect()->route('products.create')->with('successmsg','Successfully Created!!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function stockstore(Request $request)
    {   

        $stock = new Stock;
        $stock->quantity = request('quantity');
        $stock->product_id = $product->id;

        if ($request->quantity) {
            $stock->quantity = $request->quantity;
        }else{
            $stock->quantity = 0;
        }

        $stock->save();
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
        $product = Product::find($id);
        $subcategories = Subcategory::all();
        // $stock= Stock::all();
        $stock = Stock::where('product_id',$product->id)->first();
        
        return view('backend.products.edit',compact('product','subcategories','stock'));
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
            'name' => 'required',
            'subcategoryname' => 'required',
            'order_price' => 'required | min: 0',
            'sale_price' => 'required | numeric | min:0'
        ]);

        $product = Product::find($id);
        $product->name = request('name');
        $product->subcategory_id = request('subcategoryname');
        $product->order_price = request('order_price');
        $product->sale_price = request('sale_price');

        $product->save();

        

        return redirect()->route('products.index')->with('successmsg','Successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        $product->delete();

        return redirect()->route('products.index');
    }
}
