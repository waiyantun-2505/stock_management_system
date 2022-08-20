<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;
use App\Subcategory;
use App\Branch;
use App\Product;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::all();

        return view('backend.stocks.index',compact('branches'));
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
        return view('backend.stocks.create',compact('subcategories','branches'));
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
            "branchname" => 'required',
            "subcategoryname" => 'required'

        ]);

        $products = Product::all();
        $rowcount = $products->count() + 1;

        for ($i=1; $i < $rowcount; $i++) { 
             $branch_id = request("branchname");
             // $subcategory_id = request("subcategoryname".$i);
             $product_id = request("product_id".$i);
             $quantity = request("quantity".$i);
             
            $stock = Stock::where('product_id',$product_id)->where('branch_id',$branch_id)->first();
             if ($quantity ==!null) {
                
                 if ($stock == !null) {
                     $update = Stock::find($stock->id);
                     $update->quantity= $quantity;
                     $update->save();
                 }
             }

             if($quantity == !null){
                if ($stock == null) {
                     $stock = new Stock;

                    $stock->quantity = $quantity;
                    $stock->product_id = $product_id;
                    $stock->branch_id = $branch_id;
                    $stock->save();
                }
             }
               
         } 
        return redirect()->route('stocks.index')->with('successmsg','Successfully Added');

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
        //
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
            'quantity' => 'required'
        ]);

        $stock =  Stock::find($id);
        $stock->quantity = request('quantity');
        $stock->save();

        return back()->with('successmsg','Successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stock = Stock::find($id);
        $stock->delete();

        return back()->with('successmsg','Successfully Deleted!!');
    }
}
