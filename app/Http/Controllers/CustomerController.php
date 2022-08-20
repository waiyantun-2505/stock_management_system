<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\City;
use App\Marketer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $customers = Customer::orderby('id','desc')->get();
        return view('backend.customers.index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $cities = City::all();
        $marketers = Marketer::all();
        return view('backend.customers.create',compact('cities','marketers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     "name" => 'required',
        //     "phone" => 'required | array', 
        //     "city_id" => 'required',
        //     "address" => 'required | min:10'
        // ]);

        
        // sepearte with comma
        $phone = implode(',', request('phone')); 
        
        $delivery_phone = request('delivery_phone');

        $customer = new Customer;
        $customer->name = request('name');
        $customer->phone = $phone;
        $customer->city_id= request('city_id');
        $customer->address = request('address');
        
        // dd(request('delivery_phone'));

        if (request('wayname') != null) {
            $customer->way = request('wayname');
        }

        if (request('marketer_id') != null) {
            $customer->marketer_id = request('marketer_id');
        }else{
            $customer->marketer_id = Null;
        }

        if (request('delivery_gate') != null) {
            $customer->delivery_gate = request('delivery_gate');
        }
        if (!empty($delivery_phone[0])) {
            $delivery_phone_im = implode(',', request('delivery_phone')); 
            $customer->delivery_phone = $delivery_phone_im;
            

        }
        // dd(request('delivery_phone'));

        $customer->save();

        return redirect()->route('customers.index')->with('successmsg','Successfully Save!!');
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
        $customer = Customer::find($id);

        $marketers = Marketer::all();

        $cities = City::all();

        $phone = [];

        $delivery_phone = [];


        if ($customer->phone != null) {
            $phone = explode(',',$customer->phone);
            $count = count($phone);
            foreach ($phone as $value) {
               
            }
            

        }else{
            $phone;
        }

        if ($customer->delivery_phone != null) {
            $delivery_phone = explode(',',$customer->delivery_phone);
            $count = count($delivery_phone);

        }else{
            $delivery_phone;
        }



        

        return view('backend.customers.edit',compact('customer','cities','phone','marketers','delivery_phone'));
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
            "phone" => 'required | array', 
            "city_id" => 'required',
            "address" => 'required | min:10'
        ]);

        $phone = implode(',', request('phone')); 

        $customer = Customer::find($id);
        $customer->name = request('name');
        $customer->phone = $phone;
        $customer->city_id = request('city_id');
        $customer->address = request('address');
        
        if (request('wayname') != null) {
            $customer->way = request('wayname');

        }

        if (request('wayname') != null) {
            $customer->way = request('wayname');
        }

        if (request('marketer_id') != null) {
            $customer->marketer_id = request('marketer_id');
        }else{
            $customer->marketer_id = Null;
        }

        if (request('delivery_gate') != null) {
            $customer->delivery_gate = request('delivery_gate');
        }

        
        // -------------------------------------------------
            $delivery_p = request('delivery_phone');
            $count  = count(request('delivery_phone'));
            $delivery_phone_array = [];

            for ($i=0; $i < $count; $i++) { 
                if ($delivery_p[$i] != Null) {

                    $delivery_phone_array[] = $delivery_p[$i];
                    
                }
            }

            if (count($delivery_phone_array) > 1) {
                $delivery_phone_implode = implode(',', $delivery_phone_array); 
                $customer->delivery_phone = $delivery_phone_implode;
            }else{
                $customer->delivery_phone = $delivery_phone_array;
            }
        // -------------------------------------------------

        $customer->save();


        return redirect()->route('customers.index')->with('successmsg','Successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        $customer->delete();

        return redirect()->route('customers.index')->with('successmsg','Successfully Deleted!!');
    }
}
