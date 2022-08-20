<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::all();

        return view('backend.branches.index',compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.branches.create');
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
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required | array', 

        ]);
        $phone = implode(',', request('phone'));

        $branch = new Branch;
        $branch->name = request('name');
        $branch->address = request('address');
        $branch->phone = $phone;
        $branch->save();

        return redirect()->route('branches.index')->with('successmsg','Successfully Created!!');
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
        $branch = Branch::find($id);
        $phone = explode(',',$branch->phone);

        return view('backend.branches.edit',compact('branch','phone'));
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
            'address' => 'required',
            'phone' => 'required | array'
        ]);

        $phone = implode(',', request('phone'));

        $branch = Branch::find($id);
        $branch->name = request('name');
        $branch->address = request('address');
        $branch->phone = $phone;
        $branch->save();

        return redirect()->route('branches.index')->with('successmsg','Successfully Updated!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->status = "Deactive";
        $branch->save();

        return redirect()->route('branches.index')->with('successmsg',$branch->name.' is Successfully Cancelled!!');
    }
}
