<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

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
            ->where('STATUS', '1')
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

            $qty = arr::add($qty , 'C2H2', $C2H2);
            $qty = arr::add($qty , 'CO2', $CO2);
            $qty = arr::add($qty , 'AR', $AR);
            $qty = arr::add($qty , 'COMPMED', $COMPMED);
            $qty = arr::add($qty , 'H', $H);
            $qty = arr::add($qty , 'IO2', $IO2);
            $qty = arr::add($qty , 'LPG', $LPG);
            $qty = arr::add($qty , 'N2', $N2);
            $qty = arr::add($qty , 'MO2', $MO2);
            $qty = arr::add($qty , 'N2O', $N20);

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

            $noController = array([
                'DR_NO' => $request-> invoiceNo,
                'REMARKS' => 'DONE'
            ]);

            db::table('dr_assigned_report')
                ->insert($noController);

            if($request -> cylinderType == 1){ // ICR
                if($request -> inputtedTypeId == ""){

                }else{

                    db::table('cylinder_receipt')
                        ->where('ICR_NO', $request->inputtedTypeId)
                        ->update([
                            'ICR_TAG' => "1"
                        ]);

                    $delivery_qty1 = 0 ; $delivery_qty6 = 0 ; $delivery_qty10 = 0 ; $delivery_qty14 = 0 ; $delivery_qty18 = 0 ;
                    $delivery_qty2 = 0 ; $delivery_qty7 = 0 ; $delivery_qty11 = 0 ; $delivery_qty15 = 0 ; $delivery_qty19 = 0 ;
                    $delivery_qty3 = 0 ; $delivery_qty8 = 0 ; $delivery_qty12 = 0 ; $delivery_qty16 = 0 ; $delivery_qty20 = 0 ;
                    $delivery_qty4 = 0 ; $delivery_qty9 = 0 ; $delivery_qty13 = 0 ; $delivery_qty17 = 0 ; $delivery_qty21 = 0 ;
                    $delivery_qty5 = 0 ;

                    for($i = 0; $i < count($request -> productCode) ; $i++ ){

                        if($request -> productCode[$i] == "C2H2"){
                            if($request -> productSize[$i] == "PRESTOLITE"){
                                $delivery_qty1 += (int) $request -> productQty[$i];
                            }if($request -> productSize[$i] == "MEDIUM"){
                                $delivery_qty2 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty3 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "AR"){
                            if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty4 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "CO2"){
                            if($request -> productSize[$i] == "PRESTOLITE") {
                                $delivery_qty5 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty6 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "H"){
                            if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty7 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "IO2"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty8 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "MEDIUM"){
                                $delivery_qty9 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty10 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "LPG"){
                            if($request -> productSize[$i] == "11KG"){
                                $delivery_qty11 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "22KG"){
                                $delivery_qty12 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "50KG"){
                                $delivery_qty13 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "MO2"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty14 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "MEDIUM"){
                                $delivery_qty15 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty16 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "N2"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty17 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty18 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "N20"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty19 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty20 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "COMPMED"){
                            if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty21 = $request -> productQty[$i];
                            }
                        }
                    }

                    $delivery_new_data = array([
                        'DR_NO' => $request -> invoiceNo,
                        'INVOICE_DATE' => $request -> invoiceDate,
                        'ICR_NO' => $request -> inputtedTypeId,
                        'C2H2_PRESTOLITE' =>$delivery_qty1,
                        'C2H2_MEDIUM' =>$delivery_qty2,
                        'C2H2_STANDARD' =>$delivery_qty3,
                        'AR_STANDARD' =>$delivery_qty4,
                        'CO2_FLASK' =>$delivery_qty5,
                        'CO2_STANDARD' =>$delivery_qty6,
                        'H_STANDARD' =>$delivery_qty7,
                        'IO2_FLASK' =>$delivery_qty8,
                        'IO2_MEDIUM' =>$delivery_qty9,
                        'IO2_STANDARD'=>$delivery_qty10,
                        'LPG_11KG'=>$delivery_qty11,
                        'LPG_22KG'=>$delivery_qty12,
                        'LPG_50KG'=>$delivery_qty13,
                        'MO2_FLASK'=>$delivery_qty14,
                        'MO2_MEDIUM'=>$delivery_qty15,
                        'MO2_STANDARD'=>$delivery_qty16,
                        'N2_FLASK'=>$delivery_qty17,
                        'N2_STANDARD'=>$delivery_qty18,
                        'N2O_FLASK'=>$delivery_qty19,
                        'N2O_STANDARD'=>$delivery_qty20,
                        'COMPMED_STANDARD'=>$delivery_qty21
                    ]);

                    db::table('delivery_new')
                        ->insert($delivery_new_data);

                    db::table('pickup_new')
                        ->where('ICR_NO', $request->inputtedTypeId)
                        ->update(['DR_NO' => $request -> invoiceNo]);
                }


            }elseif($request -> cylinderType == 2){
                if($request -> inputtedTypeId == ""){

                }else{

                    db::table('delivery_new')
                        ->where('CLC_NO', $request->inputtedTypeId)
                        ->update(['DR_NO' => $request -> invoiceNo]);

                    db::table('cylinder_loan_contract')
                        ->where('CLC_NO', $request->inputtedTypeId)
                        ->update([
                            'CLC_TAG' => "1"
                        ]);


                }
            }elseif($request->cylinderType == 0){
                if($request -> inputtedTypeId == ""){

                }else {
                    $delivery_qty1 = 0 ; $delivery_qty6 = 0 ; $delivery_qty10 = 0 ; $delivery_qty14 = 0 ; $delivery_qty18 = 0 ;
                    $delivery_qty2 = 0 ; $delivery_qty7 = 0 ; $delivery_qty11 = 0 ; $delivery_qty15 = 0 ; $delivery_qty19 = 0 ;
                    $delivery_qty3 = 0 ; $delivery_qty8 = 0 ; $delivery_qty12 = 0 ; $delivery_qty16 = 0 ; $delivery_qty20 = 0 ;
                    $delivery_qty4 = 0 ; $delivery_qty9 = 0 ; $delivery_qty13 = 0 ; $delivery_qty17 = 0 ; $delivery_qty21 = 0 ;
                    $delivery_qty5 = 0 ;

                    for($i = 0; $i < count($request -> productCode) ; $i++ ){

                        if($request -> productCode[$i] == "C2H2"){
                            if($request -> productSize[$i] == "PRESTOLITE"){
                                $delivery_qty1 += (int) $request -> productQty[$i];
                            }if($request -> productSize[$i] == "MEDIUM"){
                                $delivery_qty2 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty3 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "AR"){
                            if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty4 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "CO2"){
                            if($request -> productSize[$i] == "PRESTOLITE") {
                                $delivery_qty5 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty6 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "H"){
                            if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty7 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "IO2"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty8 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "MEDIUM"){
                                $delivery_qty9 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty10 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "LPG"){
                            if($request -> productSize[$i] == "11KG"){
                                $delivery_qty11 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "22KG"){
                                $delivery_qty12 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "50KG"){
                                $delivery_qty13 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "MO2"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty14 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "MEDIUM"){
                                $delivery_qty15 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty16 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "N2"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty17 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty18 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "N20"){
                            if($request -> productSize[$i] == "FLASK"){
                                $delivery_qty19 = $request -> productQty[$i];
                            }if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty20 = $request -> productQty[$i];
                            }
                        }if($request -> productCode[$i] == "COMPMED"){
                            if($request -> productSize[$i] == "STANDARD"){
                                $delivery_qty21 = $request -> productQty[$i];
                            }
                        }

                    }

                    $delivery_new_data = array([
                        'DR_NO' => $request -> invoiceNo,
                        'INVOICE_DATE' => $request -> invoiceDate,
                        'CLC_NO' => $request -> inputtedTypeId,
                        'C2H2_PRESTOLITE' =>$delivery_qty1,
                        'C2H2_MEDIUM' =>$delivery_qty2,
                        'C2H2_STANDARD' =>$delivery_qty3,
                        'AR_STANDARD' =>$delivery_qty4,
                        'CO2_FLASK' =>$delivery_qty5,
                        'CO2_STANDARD' =>$delivery_qty6,
                        'H_STANDARD' =>$delivery_qty7,
                        'IO2_FLASK' =>$delivery_qty8,
                        'IO2_MEDIUM' =>$delivery_qty9,
                        'IO2_STANDARD'=>$delivery_qty10,
                        'LPG_11KG'=>$delivery_qty11,
                        'LPG_22KG'=>$delivery_qty12,
                        'LPG_50KG'=>$delivery_qty13,
                        'MO2_FLASK'=>$delivery_qty14,
                        'MO2_MEDIUM'=>$delivery_qty15,
                        'MO2_STANDARD'=>$delivery_qty16,
                        'N2_FLASK'=>$delivery_qty17,
                        'N2_STANDARD'=>$delivery_qty18,
                        'N2O_FLASK'=>$delivery_qty19,
                        'N2O_STANDARD'=>$delivery_qty20,
                        'COMPMED_STANDARD'=>$delivery_qty21
                    ]);

                    $delivery_new_data2 = array([
                        'DR_NO' => $request -> invoiceNo,
                        'INVOICE_DATE' => $request -> invoiceDate,
                        'ICR_NO' => $request -> inputtedTypeId,
                        'C2H2_PRESTOLITE' =>$delivery_qty1,
                        'C2H2_MEDIUM' =>$delivery_qty2,
                        'C2H2_STANDARD' =>$delivery_qty3,
                        'AR_STANDARD' =>$delivery_qty4,
                        'CO2_FLASK' =>$delivery_qty5,
                        'CO2_STANDARD' =>$delivery_qty6,
                        'H_STANDARD' =>$delivery_qty7,
                        'IO2_FLASK' =>$delivery_qty8,
                        'IO2_MEDIUM' =>$delivery_qty9,
                        'IO2_STANDARD'=>$delivery_qty10,
                        'LPG_11KG'=>$delivery_qty11,
                        'LPG_22KG'=>$delivery_qty12,
                        'LPG_50KG'=>$delivery_qty13,
                        'MO2_FLASK'=>$delivery_qty14,
                        'MO2_MEDIUM'=>$delivery_qty15,
                        'MO2_STANDARD'=>$delivery_qty16,
                        'N2_FLASK'=>$delivery_qty17,
                        'N2_STANDARD'=>$delivery_qty18,
                        'N2O_FLASK'=>$delivery_qty19,
                        'N2O_STANDARD'=>$delivery_qty20,
                        'COMPMED_STANDARD'=>$delivery_qty21
                    ]);

                    db::table('delivery_new')
                        ->insert($delivery_new_data2);

                    db::table('pickup_new')
                        ->insert($delivery_new_data);
                }
            }

            return response()->json(array('status' => 'success'));

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
