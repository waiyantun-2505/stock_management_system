<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Creditsale;
use App\Creditpayment;
use Carbon\Carbon;
use App\Branch;
use DB;

class CreditpaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // $branch_id = $id;

        $credit_payments = Creditpayment::orderby('date','desc')->get();

        // $credit_payments = Creditpayment::with('creditsale')->where('creditsale_id->branch_id','=',$id)->get();

        return view('backend.creditpayments.index',compact('credit_payments'));

        // dd($branch_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        
        $credit_payments = Creditpayment::whereHas('creditsale', function ($query) use ($id) {
                return $query->where('branch_id', $id);
            })->orderby('date','desc')->get();

        $branch = Branch::find($id);

        return view('backend.creditpayments.show',compact('credit_payments','branch'));

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
        
        $credit_payment = Creditpayment::find($id);

        $minus_amount = $credit_payment->amount;
        $voucher_no = $credit_payment->voucher_no;

        $creditsale = Creditsale::where('id',$credit_payment->creditsale_id)->first();
        $creditsale->payamount = $creditsale->payamount - $minus_amount;
        $creditsale->save();

        $credit_payment->delete(); 

        return redirect()->route('creditpayments.index')->with('successmsg', 'Credit Payment Voucher No. ' .$voucher_no.' is deleted');

    }


    // ----------------------------------------------------


    public function payment($id)
    {  
        $done_creditsale = Creditsale::where('status','Active')->whereColumn('balance', '=', 'payamount')->get();
        // dd($done_creditsale);

        $done_id = Creditsale::select('id')->where('status','Active')->whereColumn('balance', '=', 'payamount')->get();

        $branch = Branch::find($id);

        // $creditsale_month = Creditsale::where('status','Active')->where('branch_id',$id)->whereColumn('')

        

        if ($done_creditsale->isempty()) {
            $payment_month = Creditsale::where('status','Active')->where('branch_id',$id)->where('credit_method','=','credit')->get();
            $payment_one = Creditsale::where('status','Active')->where('branch_id',$id)->where('credit_method','=','1week')->get();
            $payment_two = Creditsale::where('status','Active')->where('branch_id',$id)->where('credit_method','=','2week')->get();
        }else{
            $payment_month = Creditsale::where('status','Active')->where('branch_id',$id)->where('credit_method','=','credit')->wherenotIN('id',$done_id)->get();
            $payment_one = Creditsale::where('status','Active')->where('branch_id',$id)->where('credit_method','=','1week')->wherenotIN('id',$done_id)->get();
            $payment_two = Creditsale::where('status','Active')->where('branch_id',$id)->where('credit_method','=','2week')->wherenotIN('id',$done_id)->get();
        }

        
        
        return view('backend.creditpayments.payment',compact('branch','done_creditsale','payment_month','payment_one','payment_two'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function payment_form($id)
    {
        $creditsale = Creditsale::find($id);

        $creditpayment = Creditpayment::where('creditsale_id',$id)->get();

        $branch_id = $creditsale->branch_id;

        // dd($creditpayment);
        $paid_amount = 0;

        if (count($creditpayment) > 0) {
            foreach ($creditpayment as $payment) {
                $paid_amount =  $paid_amount + $payment->amount;
            }
        }else{
            $paid_amount = 0;
        }

        $max_amount = $creditsale->balance - $paid_amount;

        return view('backend.creditpayments.payment_form',compact('creditsale','branch_id','creditpayment','paid_amount','max_amount'))->with([
            "name" => $creditsale->customer->name,
        ]);
    }

    public function payment_store(Request $request, $id)
    {

        $request->validate([
            "amount" => 'required |numeric | min:0 ',
        ]);

        $amount = request('amount');

        $creditpayment = Creditpayment::orderby('voucher_no','desc')->first();

        $credit_payment = New Creditpayment;
        if (empty($creditpayment)) {
            $credit_payment->voucher_no = 1;
        }else{
            $credit_payment->voucher_no = $creditpayment->id + 1;
        }

        $credit_payment->date = Carbon::today()->todatestring();
        $credit_payment->creditsale_id = $id;
        $credit_payment->amount = $amount;
        $credit_payment->save();

        $creditsale = Creditsale::find($id);
        $creditsale->payamount = $creditsale->payamount + $amount;
        $creditsale->save();


        //alert message
        $customer_name = $creditsale->customer->name;
       
       // echo $amount.' is paid by the '.$customer_name;

        
        return redirect()->route('payment',$creditsale->branch_id)->with('successmsg', $customer_name.' paid '.$amount);
        
    }

    public function payment_delete($id)
    {
        $credit_sale = Creditsale::find($id);

        $payment = Creditpayment::where("creditsale_id",$credit_sale->id)->first();
        $amount = $payment->amount;
        

        $credit_sale->payamount -= $payment->amount;

        $credit_sale->save();

        $payment->delete();

        return redirect()->route('payment',$creditsale->branch_id)->with('successmsg', $amount.'is deduct from paid.');

    }

    public function payment_detail($value='')
    {
        
        
        
    }

}
