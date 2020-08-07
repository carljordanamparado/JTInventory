<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliverController extends Controller
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
            $deliver = db::table('delivery_receipt')
                ->join('client', 'delivery_receipt.CLIENT_ID', '=', 'client.CLIENTID')
                ->where('delivery_receipt.AS_INVOICE', 0)
                ->where('delivery_receipt.FULLY_PAID', 0)
                ->get();

            return view('SalesRecord.DeliveryReceipt.viewdelivery')
                ->with('deliver_receipt', $deliver);
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

        $client_data = db::table('client')
            ->get();

        return view('SalesRecord.DeliveryReceipt.adddeliver')
            ->with('data', $client_data);

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
        $deliver_receipt_data = array([
            'DR_NO' => $request -> deliveryNo,
            'DR_DATE' => $request -> cylinderDate,
            'BALANCE' => str_replace( ',', '', $request -> totalAmount ),
            'TOTAL' => str_replace( ',', '', $request -> totalAmount ),
            'RECEIVED_BY' => $request -> receivedBy,
            'RECEIVED_DATE' => $request -> releasedDate,
            'FULLY_PAID' => 0,
            'CLIENT_ID' => $request -> customer,
            'AS_INVOICE' => 0
        ]);

        $deliver_receipt_data_insert = db::table('delivery_receipt')
            ->insert($deliver_receipt_data);

        $deliver_receipt_order_data = array();

        for($i = 0; $i < count($request -> productCode) ; $i++){
            $deliver_receipt_order_data = [
                'DR_NO' => $request -> deliveryNo,
                'DR_DATE' => $request -> cylinderDate,
                'PRODUCT' => $request -> productCode[$i],
                'SIZE' => $request -> productQty[$i],
                'UNIT_PRICE' => $request -> productSize[$i],
                'AS_INVOICE' => 0
            ];

            $deliver_receipt_order_data_insert = db::table('delivery_receipt_order')
                    ->insert($deliver_receipt_order_data);
        }

        $noController = array([
            'DR_NO' => $request-> deliveryNo,
            'REMARKS' => 'DONE'
        ]);

        db::table('dr_assigned_report')
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
        $data = db::table('delivery_receipt as a')
            ->select('*' ,'a.ID')
            ->join('sales_rep as b', 'a.SALESREPID', '=', 'b.ID')
            ->where('a.ID', $id)
            ->where('a.AS_INVOICE', 0)
            ->get();

        if($data->isEmpty()){
            $data = db::table('delivery_receipt as a')
                ->select('*' ,'a.ID')
                ->join('sales_rep as b', 'a.SALESREPID', '=', 'b.ID')
                ->where('a.ID', $id)
                ->where('a.AS_INVOICE', 0)
                ->get();
        }

        $dr_no = 0;

        foreach($data as $row){
            $dr_no = $row -> DR_NO;
        }


        $data_product = db::table('delivery_receipt_order')
            ->where('DR_NO', $dr_no)
            ->get();


        $client = db::table('client')
            ->get();


        return view('SalesRecord.DeliveryReceipt.editdelivery')
            ->with('dr', $data)
            ->with('data', $client)
            ->with('product', $data_product);
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
