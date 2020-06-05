<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;
use Illuminate\Support\Arr;


class SalesInvoice extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $invoice_data = db::table('client')
            ->join('sales_invoice', 'client.CLIENTID' , '=' , 'sales_invoice.CLIENT_ID')
            ->get();


        return view('SalesRecord.SalesInvoice.viewsalesinvoice')
            ->with("invoice_data", $invoice_data);
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

        return view('SalesRecord.SalesInvoice.addsalesinvoice')
            ->with('poNo', $poNo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

//        dd($request->all());

        try{
            $fullypaid = '';

            if($request -> balAmount == '0.00'){
                $fullypaid = 1;
            }else{
                $fullypaid = 0;
            }

            $sales_invoice = array([
                'INVOICE_NO' => $request -> invoiceNo,
                'INVOICE_DATE' => $request -> invoiceDate,
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
                'PAYMENT_TYPE' => $request -> PaymentType
            ]);

            $sales_invoice_insert = db::table('sales_invoice')
                ->insert($sales_invoice);

            $sales_invoice_order = '';

            for($i = 0; $i < count($request -> productCode) ; $i++ ){
                $sales_invoice_order = array([
                    'INVOICE_NO' => $request -> invoiceNo,
                    'INVOICE_DATE' => $request -> invoiceDate,
                    'PRODUCT' => $request -> productCode[$i],
                    'SIZE' => $request -> productSize[$i],
                    'UNIT_PRICE' => (str_replace( ',', '', $request -> productPrice[$i])),
                    'QTY' => $request -> productQty[$i]
                ]);

                $sales_invoice_order_insert = db::table('sales_invoice_order')
                    ->insert($sales_invoice_order);
            }

            $sales_invoice_po = array([
                'INVOICE_NO' => $request -> invoiceNo,
                'INVOICE_DATE' => $request -> invoiceDate,
                'SALESREPID' => $request -> issuedId,
                'CLIENT_ID' => $request -> custDetails,
                'PO_NO' => $request -> poNo
            ]);

            $sales_invoice_po_insert = db::table('sales_invoice_po')
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
                'INVOICE_NO' => $request -> invoiceNo,
                'CLIENT_NAME' => $request -> custDetails,
                'PO_NO' => $request -> poNo,
                'INVOICE_DATE' => $request -> invoiceDate,
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
                'TOTAL' => $request->grandTotal
            ]);

            $sales_invoice_report_insert = db::table('sales_invoice_report')
                ->insert($sales_invoice_report);

            if($request -> particular == ""){
                $count = 0;
            }else{
                $count = $request -> particular;
            }

            for($i = 0; $i < $count; $i++){
                $data_array = array([
                    'INVOICE_NO' => $request -> invoiceNo,
                    'QUANTITY' => $request -> qty[$i],
                    'UNIT_PRICE' => str_replace( ',', '', $request -> unitPrice[$i]),
                    'PARTICULAR' => $request -> particular[$i]
                ]);

                $other_insert = db::table('other_charges')
                    ->insert($data_array);
            }

            return response()->json(array('status' => 'success'));

        }catch (Exception $e){
            return response()->json(array('error' => $e));
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
