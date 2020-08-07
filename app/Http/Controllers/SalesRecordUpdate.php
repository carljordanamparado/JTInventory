<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SalesRecordUpdate extends Controller
{
    //
    public function updateCLC(Request $request){

        $id = $request->id;

        $cylinder_loan_data = [
            'CLC_NO' => $request-> clcNo,
            'CLC_DATE' => $request -> cylinderDate,
            'CLIENT_NO' => $request -> customer,
            'RELEASEDBY' => $request -> releasedBy,
            'RECEIVED_DATE' => $request -> releasedDate,
            'RECEIVEDBY' => $request -> receivedBy,
            'INVOICE' => $request -> invoiceNo
        ];

        $cylinder_loan_insert = db::table('cylinder_loan_contract')
            ->where('ID', $id)
            ->update($cylinder_loan_data);

        ;

        if($request->productCode == ""){

        }else{
            for($i = 0 ; $i < count($request -> productCode) ; $i++){
                $cylinder_loan_product = [
                    'CLC_NO' => $request -> clcNo,
                    'CLC_DATE' => $request -> cylinderDate,
                    'CLIENT_NO' => $request -> customer,
                    'PRODUCT' => $request -> productCode[$i],
                    'SIZE' => $request -> productSize[$i],
                    'QUANTITY' => $request -> productQty[$i]
                ];

                $clylinder_loan_product_insert = db::table('cylinder_loan_contract_list')
                    ->insert($cylinder_loan_product);
            }
        }
        return response()->json(array('status' => 'success'));
    }

    public function updateICR (Request $request){
        $id = $request->id;
        $type1 = '';
        $type2 = '';
        $type3 = '';
        $otherDescription = '';


        if($request -> cylinderType == 1){
            $type1 = 1;
        }elseif($request -> cylinderType == 2){
            $type2 = 1;
        }else{
            $type3 = 1;
            $otherDescription = $request -> OtherDecription;
        }
        $cylinder_receipt_data = [
            'ICR_NO' => $request -> icrNo,
            'ICR_DATE' => $request -> cylinderDate,
            'CLIENT_NO' => $request -> customer,
            'REFILL' => $type1,
            'RETURNED' => $type2,
            'OTHERS' => $type3,
            'OTHERS_TEXT' => $otherDescription,
            'RELEASEDBY' => $request -> receivedBy,
            'RECEIVED_DATE' => $request -> releasedDate,
            'RECEIVEDBY' => $request -> releasedBy,
            'ICR_TAG' => 0,
            'STATUS' => 1
        ];

        $cylinder_receipt_insert = db::table('cylinder_receipt')
            ->where('ID', $id)
            ->update($cylinder_receipt_data);


        if($request->productCode == ""){

        }else{
            for($i = 0 ; $i < count($request -> productCode) ; $i++){
                $cylinder_list_data = [
                    'ICR_NO' => $request -> icrNo,
                    'ICR_DATE' => $request -> cylinderDate,
                    'CLIENT_NO' => $request -> customer,
                    'PRODUCT' => $request -> productCode[$i],
                    'SIZE' => $request -> productSize[$i],
                    'QUANTITY' => $request -> productQty[$i]
                ];

                $cylinder_receipt_insert = db::table('cylinder_receipt_list')
                    ->insert($cylinder_list_data);

            }
        }
        return response()->json(array('status' => 'success'));
    }

    public function updateDELIVER(Request $request){
        $id = $request->id;

        $amount_data = db::table('delivery_receipt')
            ->where('ID', $id)
            ->get();

        $total = 0;
        $balance = 0;

        foreach($amount_data as $amt){
            $total = $amt -> TOTAL;
            $balance = $amt -> BALANCE;
        }

        $deliver_receipt_data = [
            'DR_NO' => $request -> deliveryNo,
            'DR_DATE' => $request -> cylinderDate,
            'BALANCE' => str_replace( ',', '', $request -> totalAmount + $balance ),
            'TOTAL' => str_replace( ',', '', $request -> totalAmount + $total ),
            'RECEIVED_BY' => $request -> receivedBy,
            'RECEIVED_DATE' => $request -> releasedDate,
            'FULLY_PAID' => 0,
            'CLIENT_ID' => $request -> customer,
            'AS_INVOICE' => 0
        ];

        $cylinder_receipt_insert = db::table('delivery_receipt')
            ->where('ID', $id)
            ->update($deliver_receipt_data);

        if($request->productCode == ""){

        }else {

            for ($i = 0; $i < count($request->productCode); $i++) {
                $deliver_receipt_order_data = [
                    'DR_NO' => $request->deliveryNo,
                    'DR_DATE' => $request->cylinderDate,
                    'PRODUCT' => $request->productCode[$i],
                    'SIZE' => $request->productQty[$i],
                    'UNIT_PRICE' => $request->productSize[$i],
                    'AS_INVOICE' => 0,
                ];

                $deliver_receipt_order_data_insert = db::table('delivery_receipt_order')
                    ->insert($deliver_receipt_order_data);
            }
        }

        return response()->json(array('status' => 'success'));
    }

    public function updateDELIVERSALES(Request $request){
        $id = $request->id;

        if($request -> balAmount == '0.00'){
            $fullypaid = 1;
        }else{
            $fullypaid = 0;
        }

        $po  = 0;

        if($request->poNo == ""){
            $po = 0;
        }else{
            $po = $po;
        }

        $sales_invoice = [
            'DR_NO' => $request -> invoiceNo,
            'DR_DATE' => $request -> invoiceDate,
            'DEPOSIT' => (str_replace( ',', '', $request -> depositAmt)),
            'DOWNPAYMENT' => (str_replace( ',', '', $request -> downPay)),
            'BALANCE' => (str_replace( ',', '', $request -> balAmount)),
            'TOTAL' => (str_replace( ',', '', $request -> grandTotal)),
            'SALESREPID' => $request -> issuedBy,
            'RECEIVED_BY' => $request -> recBy,
            'RECEIVED_DATE' => $request -> recDate,
            'CLIENT_ID' => $request -> custDetails,
            'FULLY_PAID' => $fullypaid,
            'CYLINDER_ENTRY' => $request -> cylinderType,
            'CYLINDER_IDS' => $request -> inputtedTypeId ,
            'AS_INVOICE' => 1
        ];

        $cylinder_receipt_insert = db::table('delivery_receipt')
            ->where('ID', $id)
            ->update($sales_invoice);

        return response()->json(array('status' => 'success'));

    }

    public function updateSALES(Request $request){
        $id = $request->id;

        $fullypaid = '';

        if($request -> balAmount == '0.00'){
            $fullypaid = 1;
        }else{
            $fullypaid = 0;
        }

        $po  = 0;

        if($request->poNo == ""){
            $po = 0;
        }else{
            $po = $request->poNo;
        }

        $sales_invoice = [
            'INVOICE_NO' => $request -> invoiceNo,
            'INVOICE_DATE' => $request -> invoiceDate,
            'DEPOSIT' => (str_replace( ',', '', $request -> depositAmt)),
            'DOWNPAYMENT' => (str_replace( ',', '', $request -> downPay)),
            'BALANCE' => (str_replace( ',', '', $request -> balAmount)),
            'TOTAL' => (str_replace( ',', '', $request -> grandTotal)),
            'SALESREPID' => $request -> issuedBy,
            'RECEIVED_BY' => $request -> recBy,
            'RECEIVED_DATE' => $request -> recDate,
            'CLIENT_ID' => $request -> custDetails,
            'FULLY_PAID' => $fullypaid,
            'CYLINDER_ENTRY' => $request -> cylinderType,
            'CYLINDER_IDS' => $request -> inputtedTypeId
        ];

        $cylinder_receipt_insert = db::table('sales_invoice')
            ->where('ID', $id)
            ->update($sales_invoice);

        return response()->json(array('status' => 'success'));
    }

    public function updateOR(Request $request){


        $or_data = [
            'OR_NO' => $request->orNo,
            'OR_DATE' => $request->cylinderDate,
            'RECEIVED_FROM' => $request-> issuedBy,
            'CLIENT_ID' => $request->customer,
            'SALESREPID' => $request -> issuedBy,
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
        ];

        $id = $request->id;

        $cylinder_receipt_insert = db::table('official_receipt')
            ->where('ID', $id)
            ->update($or_data);

        return response()->json(array('status' => 'success'));
    }
}
