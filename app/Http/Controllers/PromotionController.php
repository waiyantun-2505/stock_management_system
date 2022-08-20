<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Promotion;
use Carbon\Carbon;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        $today = Carbon::now('Asia/Yangon');
        // echo $today;

        $promotion = Promotion::where('from','<',$today)->where('to','>',$today)->first();

        if (!empty($promotion)) {
            $end_promotion = Promotion::wherenotIn('id',[$promotion->id])->get();
        }else{
            $end_promotion = Promotion::all();
        }

        // dd($promotion);

        return view('backend.promotions.index',compact('promotion','end_promotion'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        


        return view('backend.promotions.create');

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
            "name"          => 'required',
            "start_date"    => 'required',
            "end_date"      => 'required | after:start_date'
        ]);



        $promotion = new Promotion;
        $promotion->name = request('name');
        $promotion->from = request('start_date');
        $promotion->to   = request('end_date');
        $promotion->save();

        return redirect()->route('promotions.index')->with('successmsg',$promotion->name.' is Successfully Created');


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
        $promotion = Promotion::find($id);

        return view('backend.promotions.edit',compact('promotion'));
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
            "name"          => 'required',
            "start_date"    => 'required',
            "end_date"      => 'required | after:start_date'
        ]);



        $promotion = Promotion::find($id);
        $promotion->name = request('name');
        $promotion->from = request('start_date');
        $promotion->to   = request('end_date');
        $promotion->save();

        return redirect()->route('promotions.index')->with('successmsg',$promotion->name.' is Successfully Updated');
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
