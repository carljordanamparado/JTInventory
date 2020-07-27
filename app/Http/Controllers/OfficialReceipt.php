<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficialReceipt extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if(session()->has('user')){
            $OR = db::table('official_receipt')
                ->join('client', 'official_receipt.CLIENT_ID', '=', 'client.CLIENTID')
                ->where('official_receipt.STATUS', 1)
                ->get();

            return view('SalesRecord.OfficialReceipt.viewor')
                    ->with('OR', $OR);
       }else{
           return view('login');
       }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $client = db::table('client')
            ->get();

        return view('SalesRecord.OfficialReceipt.addor')
            ->with('data', $client);
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


        $or_data = array([
            'OR_NO' => $request->orNo,
            'OR_DATE' => $request->cylinderDate,
            'RECEIVED_FROM' => $request-> issuedBy,
            'CLIENT_ID' => $request->customer,
            'SALESREPID' => $request -> issuedId,
            'PAYMENT_TYPE' => $request->cashType,
            'TOTAL' => str_replace( ',', '', $request->grossSales),
            'CHECK_NO' => $request->Checkno,
            'CHECK_DATE' =>$request->checkDate,
            'BANK' =>$request->Bank,
            'STATUS' => 1,
            'OR_TYPE'=>$request->radioType,
            'CREDITABLE'=> $request->creditable,
            'REMARKS'=>$request->Remarks,
            'PAY_MODE' =>$request->PaymentType
        ]);

        db::table('official_receipt')
            ->insert($or_data);

        $payment_type = $request->PaymentType;

        if($payment_type == 1){ // Partial Payment

            for($i = 0; $i < count($request->reportNo); $i++){
                $partial_payment = array([
                    'OR_NO'=> $request->orNo,
                    'INVOICE_NO'=> $request->reportNo[$i],
                    'DUE_AMOUNT'=>str_replace( ',', '',$request->grossSales),
                    'PAID_AMOUNT'=>str_replace( ',', '',$request->amountPaid),
                    'BALANCE'=>str_replace( ',', '',$request->remBalance),
                    'STATUS'=>0,
                ]);

                db::table('official_receipt_partial_payment')
                    ->insert($partial_payment);
            }



        }elseif($payment_type == 2){ // Over Payment

            for($i = 0; $i < count($request->reportNo); $i++) {

                $over_payment = array([
                    'OR_NO' => $request->orNo,
                    'INVOICE_NO' => $request->reportNo[$i],
                    'DUE_AMOUNT' => str_replace( ',', '',$request->grossSales),
                    'PAID_AMOUNT' => str_replace( ',', '',$request->amountPaid),
                    'BALANCE' => str_replace( ',', '',$request->remBalance),
                    'STATUS' => 0
                ]);

                db::table('official_receipt_over_payment')
                    ->insert($over_payment);
            }

        }elseif($payment_type == 0){
            for($i = 0; $i < count($request->reportNo); $i++) {
                $paid_data = array([
                    'OR_NO' => $request->orNo,
                    'INVOICE_DATE' => $request->reportDate[$i],
                    'INVOICE_NO' => $request->reportNo[$i],
                    'AMOUNT' => str_replace( ',', '',$request->reportAmount[$i]),
                ]);

                db::table('official_receipt_paid')
                    ->insert($paid_data);

                if ($request->reportType[$i] == "INVOICE") {
                    $update_sales_invoice = db::table('sales_invoice')
                        ->where('INVOICE_NO', $request->reportNo[$i])
                        ->update(['FULLY_PAID' => '1']);

                } elseif ($request->reportType[$i] == "DR") {
                    $update_sales_invoice = db::table('delivery_receipt')
                        ->where('DR_NO', $request->reportNo[$i])
                        ->update(['FULLY_PAID' => '1']);
                }
            }

        }

        $or_double_payment = array([
            'OR_NO' => $request->orNo,
            'INVOICE_NO' => $request->doublePaymentNo,
            'AMOUNT' => str_replace( ',', '',$request->doublePaymentAmt)
        ]);

        if($request->doublePaymentNo == "" || $request->doublePaymentAmt == ''){

        }else{
            db::table('official_receipt_double_paid')
                ->insert($or_double_payment);
        }

        $noController = array([
            'OR_NO' => $request-> orNo,
            'REMARKS' => 'DONE'
        ]);

        db::table('or_assigned_report')
            ->insert($noController);

        return response()->json(array('status' => 'success'));

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
