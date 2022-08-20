<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Region;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $cities = City::all();
        $regions = Region::all();
        return view('backend.cities.index',compact('cities','regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   

        $regions = Region::all();

        return view('backend.cities.create',compact('regions'));
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
            "name" => 'required',
            "region_id" => 'required'
        ]);

        $city = new City;
        $city->name = request('name');
        $city->region_id = request('region_id');

        $city->save();

        return redirect()->route('cities.index')->with('successmsg','Successfully Save!!');
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
        $city = City::find($id);

        return view('backend.cities.edit',compact('city'))->with('name',$city->name);
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
            "region_id"=>'required'
        ]);

        $city = City::find($id);
        $city->name = request('name');
        $city->region_id = request('region_id');

        $city->save();

        return redirect()->route('cities.index')->with('successmsg','Successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $city = City::find($id);
        // $city->status = "Deactive";
        // $city->save();

        // return redirect()->route('cities.index')->with('successmsg',$city->name.' is Successfully Cancelled!!');
    }
}
