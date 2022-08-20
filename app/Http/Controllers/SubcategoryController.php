<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Subcategory;
use App\Category;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $subcategories = Subcategory::all();
        $categories = Category::all();
        return view('backend.subcategories.index',compact('subcategories','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        return view('backend.subcategories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'category_id' => 'required | not_in:0'
        ]);

        $subcategory = new Subcategory;
        $subcategory->name = request('name');
        $subcategory->category_id = request('category_id');

        $subcategory->save();

        return redirect()->route('subcategories.index')->with('successmsg','Successfully Created!!');
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
            "name" => 'required',
            "category_id" => 'required'
        ]);

        $subcategory = Subcategory::find($id);
        $subcategory->category_id = request('category_id');
        $subcategory->name = request('name');

        $subcategory->save();

        return redirect()->route('subcategories.index')->with('successmsg','Successfully Updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->status = "Deactive";

        $subcategory->save();

        return redirect()->route('subcategories.index')->with('successmsg',$subcategory->name.' is Successfully Cancelled!!');
    }
}
