<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Marketer;
use Carbon\Carbon;
use App\Customer;

class MarketerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function marketer_sale($id)
    {
        
        

        return view('backend.marketers.index',compact('marketers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $marketers = Marketer::with('customers')->get();

        $today = Carbon::now();
        // echo $today;
        // $sale = Sale::where('')

        return view('backend.marketers.index',compact('marketers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.marketers.create');
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
            'name' => 'required'
        ]);

        $marketer = new Marketer;
        $marketer->name = request('name');
        $marketer->save();

        return redirect()->route('marketers.index')->with('successmeg','Successfully Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marketer = Marketer::where('id',$id)->first();
        $shop_marketers = Customer::where('marketer_id',$id)->orderby('city_id')->get();    
        // dd($marketer);
        return view('backend.marketers.show',compact('shop_marketers','marketer'));

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
            'name' => 'required'
        ]);

        $marketer_update = Marketer::find($id);
        $marketer_update->name = request('name');
        $marketer_update->save();

        return redirect()->route('marketers.index')->with('successmsg','Successfully Updated!!');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marketer = Marketer::find($id);
        $name = $marketer->name;
        $marketer->delete();

        return redirect()->route('marketers.index')->with([
            'successmsg' => $name.' is Successfully Deleted'
        ]);
    }


    

}
