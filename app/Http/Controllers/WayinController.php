<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Wayin;
use App\Wayout;
use App\Wayoutdetail;
use App\Wayindetail;
use App\Stock;
use App\Branch;
use App\Waysale;
use App\Waysaledetail;
use Carbon;

class WayinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wayins = Wayin::all();

        $wayouts = Wayout::all();

        $wayouts_done = Wayout::where('wayin_status','done')->with('wayins')->orderby('wayout_date','asc')->get();

        // dd($wayouts_pending);

        $waysales = Waysale::all();

        return view('backend.wayins.index',compact('wayins','wayouts_done','waysales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function wayin($id)
    {
        $wayout_record = Wayout::find($id);
        $wayout_detail = Wayoutdetail::where('wayout_id',$id)->get();
        $branches = Branch::all();

        $waysale = Waysale::where('wayout_id',$id)->get();

        return view('backend.wayins.create',compact('wayout_record','wayout_detail','branches','waysale'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function create()
    {


       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $waysale = Waysale::where('wayout_id',request('wayout_id'))->latest('waysale_date')->first();

        // $database_date = Carbon\Carbon::parse($waysale->waysale_date);
        // dd($waysale->waysale_date);
        // $min_date = Carbon\Carbon::createFromFormat('Y-m-d', $waysale->waysale_date)->format('m-d-Y');
        // echo $min_date;
        // $date = request('date');

        // echo $date;

        $request->validate([
            "date"  => 'required |min:',
            "branch_id" => 'required'

        ]);

        $wayin_branch = request('branch_id');
        $wayin_date = request('date');

        $wayin = new Wayin;
        $wayin->wayout_id = request('wayout_id');
        $wayin->branch_id = $wayin_branch;
        $wayin->wayin_date = $wayin_date;
        $wayin->save();

        $wayout_det = Wayoutdetail::where('wayout_id',request('wayout_id'))->get();
        $count = $wayout_det->count() + 1;

        $wayout = Wayout::find(request('wayout_id'));
        $wayout->wayin_status = 'Done';
        $wayout->save();

         // echo $count;

        $product_id_arr = [];

        foreach ($wayout_det as $det) {
            $product_id_arr[] = $det->product_id; 
        }

       for ($i=1; $i < $count; $i++) { 

            $wayout_detail = Wayoutdetail::where('wayout_id',request('wayout_id'))->where('product_id',$product_id_arr[$i-1])->first();
            // dd($wayout_detail);
            
            if ($wayout_detail->quantity != $wayout_detail->sale_quantity) {
                // echo $wayout_detail->sale_quantity;
                $final_quantity = $wayout_detail->quantity - $wayout_detail->sale_quantity; 

                $wayin_detail = new Wayindetail;
                $wayin_detail->wayin_id = $wayin->id;
                $wayin_detail->product_id = $wayout_detail->product_id;
                $wayin_detail->quantity = $final_quantity;
                $wayin_detail->save();

                $wayin_stocks = Stock::where('branch_id',$wayin_branch)->where('product_id',$wayout_detail->product_id)->first();
                $wayin_stocks->quantity = $wayin_stocks->quantity + $final_quantity;
                $wayin_stocks->save();



            }



        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
