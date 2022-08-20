<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Branch;
use App\Stock;
use App\Subcategory;
use App\Saledetail;
use App\Orderdetail;
use Carbon\Carbon;
use App\Transferdetail;
use App\Transfer;
use App\Sale;
use App\Customer;
use App\Wayoutdetail;
use App\Wayout;
use App\Waysaledetail;
use App\City;
use App\Marketer;


class BackendController extends Controller
{
    public function dashboard($value='')
    {
    	return view('backend.dashboard');
    }

    

    public function search_product(Request $request)
    {   
        

    	$id = request('id');
    	$products = Product::where('subcategory_id',$id)->with('subcategory')->get();
        // $stocks = Stock::where('product_id',$products->id)->get();

        // $products = Product::where('subcategory_id',$id)->with('stocks' => function($query){
        //     $query->where('product_id','product.product_id');
        // })->get();

        

    	return $products;
    }

    public function transfer_search($value='')
    {
        $id = request('id');

        $stocks = Stock::where('branch_id',$id)->with('product')->get();

        return $stocks;
    }

    public function transferDetail($value='')
    {
        $id = request('id');

        $transferDetails = Transferdetail::where('transfer_id',$id)->with('product')->get();

        return $transferDetails;
    }

    public function search_stock($value='')
    {
        $id = request('id');

        $stocks = Stock::where('branch_id',$id)->with('product')->get();
        // dd($stocks);
        return $stocks;
    }

    

    public function orderDetail($value='')
    {
        $id = request('id');

        $orderdetail = Orderdetail::where('order_id',$id)->with(['product','branch'])->orderby('branch_id')->get();

        return $orderdetail;
    }

    public function waysale_detail($value='')
    {
        $id = request('id');

        $waysaleDetail = Waysaledetail::where('waysale_id',$id)->with('product')->get();

        return $waysaleDetail;
    }

    public function todaySale($value='')
    {
        $today = Carbon::now()->toDateString();


        $today_sale = Sale::with(['branch','customer'])->where('saledate',$today)->orderBy('branch_id','asc')->get();

        return $today_sale;
    }

    public function wayout_search($value='')
    {
        $id = request('id');
        $stocks = Stock::where('branch_id',$id)->with('product')->get();
        // dd($stocks);
        return $stocks;
    }

    public function wayout_detail($value='')
    {
        $id = request('id');

        $wayoutdetail = Wayoutdetail::where('wayout_id',$id)->with('product')->get();

        return $wayoutdetail;
    }

    public function waysale($value='')
    {
        $id = request('id');

        $waysale_detial = Waysaledetail::where('waysale_id',$id)->with('product')->get();

        return $waysale_detial;
    }

    public function search_customer($value='')
    {
        $id = request('id');

        $customer = Customer::with(['city','marketer'])->where('id',$id)->first();

        return $customer;
    }


    // important important important important important

    public function report($value='')
    {   
        $branches = Branch::all();
        return view('backend.report',compact('branches'));
    }

    public function generate_report(Request $request)
    {
        
        $request->validate([
            'report_date' => 'required',
            'branch_id'    => 'required'
        ]);


        // convert date format

        $report_date = request('report_date');
        $branch_id = request('branch_id');

        $branch = Branch::find($branch_id);

        // echo $report_date;
        $re_date = Carbon::parse($report_date);

        // firstday of the selected month

        $first_day = Carbon::createFromFormat('Y-m-d H:i:s', $re_date)->format('yy-m-01'); 

        $month = Carbon::createFromFormat('Y-m-d H:i:s', $re_date)->format('M');

        $year = Carbon::createFromFormat('Y-m-d H:i:s', $re_date)->format('yy');

        $info = [$branch->name,$month,$year];

        

        // last day of the selected month

        $last_day = Carbon::createFromFormat('Y-m-d H:i:s', $re_date)->format('yy-m-t');


        // stock Table

        $stocks = Stock::where('branch_id',$branch_id)->get();

        // sale Table
        
        $sales = Sale::where('branch_id',$branch_id)->whereBetween('saledate',[$first_day,$last_day])->with('saledetails')->get();

        


        
        

        return view('backend.reports.reportdetail',compact('info','stocks','sales'));

    }
}
