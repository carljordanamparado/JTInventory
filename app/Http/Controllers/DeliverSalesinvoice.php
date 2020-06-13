<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliverSalesinvoice extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $poNo = db::table('client_po')
            ->get();

        $client = db::table('client')
            ->get();

        return view('SalesRecord.DeliveryReceipt.adddeliverysales')
            ->with('client', $client);
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

        if($request -> balAmount == '0.00'){
            $fullypaid = 1;
        }else{
            $fullypaid = 0;
        }

        $sales_invoice = array([
            'DR_NO' => $request -> invoiceNo,
            'DR_DATE' => $request -> invoiceDate,
            'DEPOSIT' => (str_replace( ',', '', $request -> depositAmt)),
            'DOWNPAYMENT' => (str_replace( ',', '', $request -> downPay)),
            'BALANCE' => (str_replace( ',', '', $request -> balAmount)),
            'TOTAL' => (str_replace( ',', '', $request -> grandTotal)),
            'SALESREPID' => $request -> issuedId,
            'RECEIVED_BY' => $request -> recBy,
            'RECEIVED_DATE' => $request -> recDate,
            'CLIENT_ID' => $request -> custDetails,
            'FULLY_PAID' => $fullypaid,
            'CYLINDER_ENTRY' => $request -> cylinderType,
            'CYLINDER_IDS' => $request -> inputtedTypeId ,
            'AS_INVOICE' => 1
        ]);

        $sales_invoice_insert = db::table('delivery_receipt')
            ->insert($sales_invoice);

        $sales_invoice_order = '';

        for($i = 0; $i < count($request -> productCode) ; $i++ ){
            $sales_invoice_order = array([
                'DR_NO' => $request -> invoiceNo,
                'DR_DATE' => $request -> invoiceDate,
                'PRODUCT' => $request -> productCode[$i],
                'SIZE' => $request -> productSize[$i],
                'UNIT_PRICE' => (str_replace( ',', '', $request -> productPrice[$i])),
                'QTY' => $request -> productQty[$i]
            ]);

            $sales_invoice_order_insert = db::table('delivery_receipt_order')
                ->insert($sales_invoice_order);

            $sales_invoice_po = array([
                'DR_NO' => $request -> invoiceNo,
                'DR_DATE' => $request -> invoiceDate,
                'SALESREPID' => $request -> issuedId,
                'CLIENT_ID' => $request -> custDetails,
                'PO_NO' => $request -> poNo
            ]);

            $sales_invoice_po_insert = db::table('delivery_receipt_po')
                ->insert($sales_invoice_po);

            $qty = array();
            $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
            $MO2 = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

            for($i = 0; $i < count($request -> productCode) ; $i++ ) {

                if($request -> productCode[$i] == "C2H2"){
                    $C2H2 += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "AR"){
                    $AR += (int)$request -> productQty[$i];
                }
                if($request -> productCode[$i] == "CO2"){
                    $CO2 += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "IO2"){
                    $IO2 += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "LPG"){
                    $LPG += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "MO2"){
                    $MO2 += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "N2"){
                    $N2 += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "N20"){
                    $N20 += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "H"){
                    $H += (int)$request -> productQty[$i] ;
                }
                if($request -> productCode[$i] == "COMPMED"){
                    $COMPMED += (int)$request -> productQty[$i] ;
                }
            }

            $qty = array_add($qty , 'C2H2', $C2H2);
            $qty = array_add($qty , 'CO2', $CO2);
            $qty = array_add($qty , 'AR', $AR);
            $qty = array_add($qty , 'COMPMED', $COMPMED);
            $qty = array_add($qty , 'H', $H);
            $qty = array_add($qty , 'IO2', $IO2);
            $qty = array_add($qty , 'LPG', $LPG);
            $qty = array_add($qty , 'N2', $N2);
            $qty = array_add($qty , 'MO2', $MO2);
            $qty = array_add($qty , 'N2O', $N20);

            $totalPayment = 0;
            $totalPayment2 = 0;

            if($request -> PaymentType == "1"){
                $totalPayment = (float)str_replace( ',', '', $request -> depositAmt) + (float) str_replace( ',', '', $request -> downPay);
            }elseif($request -> PaymentType == "2"){
                $totalPayment2 = (float)str_replace( ',', '', $request -> depositAmt) + (float) str_replace( ',', '', $request -> downPay);
            }

            $sales_invoice_report = array([
                'DR_NO' => $request -> invoiceNo,
                'CLIENT_NAME' => $request -> custDetails,
                'PO_NO' => $request -> poNo,
                'DR_DATE' => $request -> invoiceDate,
                'C2H2' => $qty['C2H2'],
                'AR' => $qty['AR'],
                'CO2' => $qty['CO2'],
                'IO2' => $qty['IO2'],
                'LPG' => $qty['LPG'],
                'MO2' => $qty['MO2'],
                'N2' => $qty['N2'],
                'N2O' => $qty['N2O'],
                'H' => $qty['H'],
                'COMPMED' => $qty['COMPMED'],
                'OTHERS' => $request->otherCharge,
                'CASH' => $totalPayment,
                'ACCOUNT' => $totalPayment2,
                'TOTAL' => (str_replace( ',', '', $request -> grandTotal))
            ]);

            $sales_invoice_report_insert = db::table('delivery_receipt_report')
                ->insert($sales_invoice_report);


            if($request -> particular == ""){
                $count = 0;
            }else{
                $count = $request -> particular;
            }

            dd($count);

            for($i = 0; $i < $count; $i++){
                $data_array = array([
                    'DR_NO' => $request -> invoiceNo,
                    'QUANTITY' => $request -> qty[$i],
                    'UNIT_PRICE' => str_replace( ',', '', $request -> unitPrice[$i]),
                    'PARTICULAR' => $request -> particular[$i]
                ]);

                $other_insert = db::table('dr_other_charges')
                    ->insert($data_array);
            }

            for($i = 0; $i < count($request -> productCode); $i++){

                $value = (floatval($request -> remQty) - floatval($request -> productQty[$i]));

                $remQty = db::table('client_po_list')
                    ->where('PO_NO', $request->poNo)
                    ->where('PRODUCT', $request->productCode[$i])
                    ->where('SIZE', $request->productSize[$i])
                    ->update(['QUANTITY' => $value]);
            }




        }


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
