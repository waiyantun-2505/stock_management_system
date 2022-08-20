<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;
use App\Stock;
use App\Wayout;
use App\Wayoutdetail;
use App\Wayin;
use App\Waysale;
use App\Waysaledetail;
use App\Waycreditsale;
use App\Waycreditsaledetail;

class WayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $wayouts = Wayout::where('status','Active')->orderby('wayout_date','desc')->get();
        $wayout_cancel = Wayout::where('status','Deactive')->orderby('wayout_date','asc')->get();

        $wayins = Wayin::all();

        return view('backend.wayouts.index',compact('wayouts','wayins','wayout_cancel')); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::all();

        return view('backend.wayouts.create',compact('branches'));
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
            'city' => 'required',
            'date' => 'required',
            'branch_id' => 'required'
        ]);

        $branch_stock = Stock::where('branch_id', request('branch_id'))->get();
        $stock_count = $branch_stock->count() + 1;

        $branch_id = request('branch_id');
        $date = request('date');
        $cities = request('city');

        for ($i=0; $i < $stock_count; $i++) { 
            
            $product_id = request('product_id'.$i);
            $check = request('quantity'.$i);
            
            
            if ($check == !null) {
                // wayout
                $wayout = new Wayout;
                $wayout->branch_id = $branch_id;
                $wayout->wayout_date = $date;
                $wayout->way_cities = $cities;
                $wayout->wayin_status = 'Ongoing';
                $wayout->status = 'Active';
                $wayout->save();

                for ($j=0; $j < $stock_count; $j++) { 
                    
                    $product_id = request('product_id'.$j);
                    $quantity = request('quantity'.$j);
                    // dd($wayout->id);
                    if ($quantity == !null) {
                        // Stocks
                        $stocks = Stock::where('branch_id',$branch_id)->where('product_id',$product_id)->first();
                        $stocks->quantity = $stocks->quantity - $quantity;
                        $stocks->save();

                        // wayout Detail
                        $wayout_detail = new Wayoutdetail;
                        $wayout_detail->wayout_id = $wayout->id;
                        $wayout_detail->product_id = $product_id;
                        $wayout_detail->quantity = $quantity;
                        $wayout_detail->save();
                    }

                }

                break;
            }   

        }

        return redirect()->route('wayouts.index')->with('successmg','Successfully Created!!');
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
        $wayout = Wayout::find($id);
        $wayout_detail = Wayoutdetail::where('wayout_id',$id)->get();
        // dd($wayout_detail);
        $branches = Branch::all();
        $stocks = Stock::where('branch_id',$wayout->branch_id)->with('product')->get();

        $product_id_arr = [];     

        foreach ($stocks as $stock) {
            foreach ($wayout_detail as $detail) {
                if ($stock->product_id == $detail->product_id) {
                    $product_id_arr[] = $detail->product_id;
                }
            }
        }

        $stock_arr = Stock::where('branch_id',$wayout->branch_id)->whereNotIn('product_id',$product_id_arr)->orderBy('product_id','asc')->get();

        return view('backend.wayouts.edit',compact('wayout','wayout_detail','branches','stocks','stock_arr'));

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
            'city' => 'required',
            'date' => 'required',
            'branch_id' => 'required'
        ]);

        $wayout = Wayout::find($id);
        $wayout->way_cities = request('city');
        $wayout->wayout_date = request('date');
        $wayout->branch_id = request('branch_id');
        $wayout->save();

        $detailrecords = Wayoutdetail::where('wayout_id',$id)->get()->count();
        $num_row = $detailrecords + 1;

        for ($i=1; $i < $num_row; $i++) { 
            $delete = request('delete'.$i);

            $product_id = request('product_id'.$i);
            $quantity = request('quantity'.$i);

            if ($delete == 'Delete') {

                $wayout_detail_delete = Wayoutdetail::where('wayout_id',$id)->where('product_id',$product_id)->first();

                $stock = Stock::where('branch_id',request('branch_id'))->where('product_id',$product_id)->first();
                $stock->quantity = $stock->quantity + $wayout_detail_delete->quantity;
                $stock->save();

                $wayout_detail_delete->delete();
            }else{

                $wayoutdetail = Wayoutdetail::where('wayout_id',$id)->where('product_id',$product_id)->first();

                if ($quantity < $wayoutdetail->quantity) {
                    $newquantity = $wayoutdetail->quantity - $quantity;

                    $wayoutdetail->quantity = $quantity;
                    $wayoutdetail->save();

                    

                    $stock = Stock::where('branch_id',request('branch_id'))->where('product_id',$product_id)->first();

                    $stock->quantity = $stock->quantity + $newquantity;
                    $stock->save();

                }elseif($quantity > $wayoutdetail->quantity){

                    $wayoutdetail->quantity = $quantity;
                    $wayoutdetail->save();

                    $newquantity = $quantity - $wayoutdetail->quantity;

                    $stock = Stock::where('branch_id',request('branch_id'))->where('product_id',$product_id)->first();
                    $stock->quantity = $stock->quantity - $newquantity;
                    $stock->save();

                }
             }
        } //for loop end


        $number_row = Stock::where('branch_id',request('branch_id'))->get()->count();
        $rowcount = $number_row + 1;

        // dd($number_row);

        for ($j=1; $j < $rowcount; $j++) { 
            $add_product_id = request('add_product_id'.$j);
            $add_quantity = request('add_quantity'.$j);
            

            if ($add_quantity == !null) {
                $wayout_detail = new Wayoutdetail;
                $wayout_detail->wayout_id = $id;
                $wayout_detail->product_id = $add_product_id;
                $wayout_detail->quantity = $add_quantity;
                $wayout_detail->save();

                $stock_check = Stock::where('branch_id',request('branch_id'))->where('product_id',$add_product_id)->first();
                $stock_check->product_id = $add_product_id;
                $stock_check->quantity = $stock_check->quantity - $add_quantity;
                $stock_check->save();
                
                    
                
            }

        }

        return redirect()->route('wayouts.index')->with('successmsg','Successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wayout = Wayout::find($id);
        $wayout_detail = Wayoutdetail::where('wayout_id',$id)->get();

        foreach ($wayout_detail as $detail) {
            $add_stock = Stock::where('branch_id',$wayout->branch_id)->where('product_id',$detail->product_id)->first();

            $add_stock->quantity = $add_stock->quantity + $detail->quantity;
            $add_stock->save();
            
        }

        $if_waysale = Waysale::where(['Wayout_id'=>$id,'status'=>'Active'])->get();

        if($if_waysale != Null)
        {
            foreach ($if_waysale as $waysale) 
            {
                $waysale_details = Waysaledetail::where('waysale_id',$waysale->id)->get();

                foreach ($waysale_details as $waysale_detail)
                {
                    $add_stock = Stock::where(['branch_id'=>$wayout->branch_id,'product_id'=>$waysale_detail->product_id])->tobase()->first();
                    $add_stock->quantity = $add_stock->quantity + $waysale_detail->quantity;
                    $add_stock->save();

                    $delete_waysaledetail = Waysaledetail::where(['waysale_id'=>$waysale->id,'product_id'=>$waysale_detail->product_id])->first();
                    $delete_waysaledetail->delete();

                }
            
            }
        }


        $if_waycreditsale = Waycreditsale::where(['Wayout_id'=>$id,'status'=>'Active'])->get();
        if($if_waycreditsale != Null)
        {
            foreach ($if_waycreditsale as $waycreditsale) 
            {
                $waycreditsale_details = Waysaledetail::where('waysale_id',$waycreditsale->id)->get();

                foreach ($waycreditsale_details as $waycreditsale_detail)
                {
                    $add_stock = Stock::where(['branch_id'=>$wayout->branch_id,'product_id'=>$waycreditsale_detail->product_id])->tobase()->first();
                    $add_stock->quantity = $add_stock->quantity + $waycreditsale_detail->quantity;
                    $add_stock->save();

                    $delete_waycreditsaledetail = Waysaledetail::where(['waysale_id'=>$waysale->id,'product_id'=>$waycreditsale_detail->product_id])->first();
                    $delete_waycreditsaledetail->delete();

                }
            
            }
        }

        $wayout->status = 'Deactive';
        $wayout->save();

        return redirect()->route('wayouts.index')->with('successmsg','Successfully Cancelled !!');
    }
}
