<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JqueryController extends Controller
{
    //
    public function prodCodeToSize(Request $request){

      $prodCode = $request -> prodcode;
      $html = '';

      $prodSize = DB::table('product_size')
                    ->where('PROD_CODE', $prodCode)
                    ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->SIZES == ''){

            }else {
                $html .= '<option value="' . $prodSize->SIZES . '">' . $prodSize->SIZES . '</option>';
            }
        }
      return response()->json([$html]);
    }

    public function getProductSize2(Request $request){
            $prodCode = $request -> prodcode;
            $html = '';

             $prodSize = DB::table('client')
                 ->join('product_list', 'client.CLIENTID', '=', 'product_list.CLIENTID')
                 ->where('PROD_CODE', $prodCode)
                 ->select('SIZE')
                 ->get();

            foreach ($prodSize as $prodSize) {
                if($prodSize->SIZE == ''){

                }else {
                    $data = $prodSize -> SIZE;
                }
            }

            return $data;
    }

    public function updateProductPrice(Request $request){

        $id = $request -> id;
        $price = $request -> price;

        $price = floatval(str_replace(",", "", $price));

        $updatePrice = DB::table('product_list')
                        ->where('id', $id)
                        ->update(['PRODUCT_PRICE' => $price]);

        if($updatePrice == 1){
		  return Response()->json(['updateStatus' => 'true']);
        }else{
		  return Response()->json(['updateStatus' => 'false']);
        }


    }

    public function getProductPO(Request $request){
        $clientCode = $request -> prodcode;
        $html = '';
        $html2 = '';

        $prodSize = DB::table('product_list')
            ->groupBy('PROD_CODE')
            ->where('CLIENTID', $clientCode)
            ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->PROD_CODE == ''){

            }else {
                $html .= '<option value="' . $prodSize->PROD_CODE . '">' . $prodSize->PRODUCT . '</option>';

            }
        }
        return response()->json(array('html' => $html));
    }

    public function getProductSizePO(Request $request){
        $clientCode = $request -> prodcode;
        $id = $request -> id;



        $html = '';
        $html2 = '';

        $prodSize = DB::table('product_list')
            ->where('CLIENTID', $id)
            ->where('PROD_CODE', $clientCode)
            ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->SIZE == ''){

            }else {
                $html .= '<option value="' . $prodSize->SIZE . '">' . $prodSize->SIZE . '</option>';
            }
        }
        return response()->json(array('html' => $html));
    }
    // Sales Invoice
    public function noValidate(Request $request)
    {
        $buttonVal = $request->buttonVal;
        $invoiceNo = $request->invoiceNo;

        if ($buttonVal == "invoice") { // Invoice

            $si_assigned = db::table('si_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'si_assigned.SALESREP_ID')
                ->where('FROM_OR_NO', '<=', $invoiceNo)
                ->where('TO_OR_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($si_assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }

            if ($si_assigned->isEmpty() == false) {

                $si_report = db::table('si_assigned_report')
                    ->where('INVOICE_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();
                if ($si_report->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID));
                } else {
                    foreach ($si_report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }

            } else {
                return Response()->json(['status' => 'empty']);
            }

        } elseif ($buttonVal == "icr") { // For Button Recognitions
            $assigned = db::table('icr_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'icr_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $invoiceNo)
                ->where('TO_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }

            if ($assigned->isEmpty() == false) {

                $report = db::table('icr_assigned_report')
                    ->where('ICR_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                if ($report->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
             }

        }elseif ($buttonVal == "clc") { // For Button Recognitions
            $assigned = db::table('clc_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'clc_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $invoiceNo)
                ->where('TO_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('clc_assigned_report')
                    ->where('CLC_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                if ($report->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }

        }elseif ($buttonVal == "DR"){
            $assigned = db::table('dr_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'dr_assigned.SALESREP_ID')
                ->where('FROM_NO', '<=', $invoiceNo)
                ->where('TO_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('dr_assigned_report')
                    ->where('DR_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                if ($report->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
        }elseif($buttonVal == "OR"){
            $assigned = db::table('or_assigned')
                ->join('sales_rep', 'sales_rep.ID', '=', 'or_assigned.SALESREP_ID')
                ->where('FROM_OR_NO', '<=', $invoiceNo)
                ->where('TO_OR_NO', '>=', $invoiceNo)
                ->get();


            $issuedBy = '';

            foreach ($assigned as $issuerName) {
                $issuedBy = $issuerName->ASSIGNED_BY;
                $issuerID = $issuerName->SALESREP_ID;
            }


            if ($assigned->isEmpty() == false) {

                $report = db::table('or_assigned_report')
                    ->where('OR_NO', $invoiceNo)
                    ->where(function ($query) {
                        $query->where('REMARKS', '=', 'DONE')
                            ->orWhere('REMARKS', '=', 'CANCELLED')
                            ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                    })
                    ->get();

                if ($report->isEmpty() == true) {
                    return response()->json(array('issuedBy' => $issuedBy, 'issuerID' => $issuerID));
                } else {
                    foreach ($report as $remarks) {
                        return response()->json(array(['status' => $remarks->REMARKS]));
                    }

                }
            }else{
                return Response()->json(['status' => 'empty']);
            }
        }
    }

    // Add Sales Invoice Customer Details
    public function poCustomerDetails(Request $request){
       $cust_id = $request-> cust_id;
       $po_id = $request-> po_id;
       $html  = '';
       $html2 = '';
       $date = '';
       $product = '';

       $cust_details = db::table('client')
           ->where('CLIENTID', $cust_id)
           ->get();

       $po_date = db::table('client_po_list')
           ->select('po_date')
           ->where('PO_NO', $po_id)
           ->distinct()
           ->get();

       $poProducts = db::table('client_po_list')
            ->select('*', 'client_po_list.ID as PROD_ID')
           ->join('products', 'products.PROD_CODE' , '=' , 'client_po_list.PRODUCT')
           ->where('PO_NO', $po_id)
           ->get();

       // Dito ko sana ilalagay kaso parang humahaba na



       foreach($cust_details as $cust_detail){
           $html .= '<option value="' . $cust_detail -> CLIENTID . '" id="custOptions" readonly>' . $cust_detail->NAME . '</option>';
           $html2 = $cust_detail->NAME;
       }

       foreach($po_date as $po_date){
           $date .= $po_date -> po_date;
       }

       foreach($poProducts as $products){
           $product .= '<option value="' . $products -> PROD_CODE . '" id="product" data-id=" '. $products -> PROD_ID . ' ">' . $products->PRODUCT . '</option>';
       }

        return response()->json(array('html' => $html , 'html2' => $html2 , 'date' => $date , 'product' => $product));
    }

    function poProductDetails(Request $request){
        $cust_id = $request-> cust_id;
        $po_id = $request-> po_id;
        $prodCode = $request -> prodCode;
        $prod_id = $request -> prodId;


        $size = '';
        $quantity = '';
        $amount = '';

        $productDetails = db::table('client_po_list')
            ->where('PO_NO', $po_id)
            ->where('ID', $prod_id)
            ->get();

//        dd($productDetails);


        $amount = db::table('client_po_list as a')
            ->join('product_list as b', 'a.CLIENTPO_ID' , '=' , 'b.CLIENTID')
            ->where('a.PO_NO', $po_id)
            ->where('b.PROD_CODE', $prodCode)
            ->groupBy('b.ID')
            ->get();

        foreach($productDetails as $product){
            $size = $product -> SIZE;
            $quantity = $product -> QUANTITY;
        }

        foreach($amount as $productAmount){
            $amount = $productAmount -> PRODUCT_PRICE;
        }

        return response()->json(array('size' => $size , 'quantity' => $quantity , 'amount' => $amount));
    }

    function invoiceNoModal(Request $request){
        $id = $request -> id;
        $tableData = '';
        $tableData2 = '';

        $product_query = DB::table('sales_invoice_order as a')
            ->join('products as b', 'a.PRODUCT', '=' , 'b.PROD_CODE')
            ->where('INVOICE_NO', $id)
            ->get();

        $particular_query = db::table('other_charges')
            ->where('INVOICE_NO', $id)
            ->get();

        $invoice_information = db::table('sales_invoice')
            ->where('INVOICE_NO', $id)
            ->get();

        foreach($product_query as $data){

            $data1 = '<td> '.$data -> PRODUCT.'</td>';
            $data2 = '<td> '.$data -> SIZE.'</td>';
            $data3 = '<td> '.$data -> UNIT_PRICE.'</td>';
            $data4 = '<td> '.$data -> QTY .'</td>';

            $tableData .= '<tr class="text-center">'.$data1. ' '. $data2 .' '.$data3.' '.$data4.'</tr>';
        }

        foreach($particular_query as $data){
            $data1 = '<td>'.$data -> PARTICULAR.'</td>';
            $data2 = '<td>'.$data -> UNIT_PRICE.'</td>';
            $data3 = '<td>'.$data -> QUANTITY.'</td>';

            $tableData2 .= '<tr class="text-center">'.$data1. ' '. $data2 .' '.$data3.' </tr>';
        }

        $deposit = 0;
        $downpay = 0;
        $totalamt = 0;
        $type = '';

        $dataArray = array();

        foreach($invoice_information as $data){

            $data1 = '';
            $data2 = '';
            $data3 = '';
            $data4 = '';

            if($data -> PAYMENT_TYPE == "1"){
                $data3 = "CASH";
            }else{
                $data3 = "ACCOUNT";
            }

            $dataArray = array([
                'Deposit' => $data -> DEPOSIT,
                'Downpayment' => $data -> DOWNPAYMENT,
                'Type' => $data3,
                'Total' => $data -> TOTAL
            ]);

        }



        return response()->json(array('table_data' => $tableData , 'table_data2' => $tableData2 , 'dataArray' => $dataArray));

    }

    public function icrProduct(Request $request){
        
        $cust_id = $request -> cust_id;
        $option = '';


        $product_query = db::table('product_list')
            ->where('CLIENTID', $cust_id)
            ->get();

        foreach($product_query as $data){
            $option .= '<option value="'.$data -> PROD_CODE.'" data-id="'.$data->ID.'"> '.$data -> PRODUCT.' </option>';
        }

        return response()->json(array('option' => $option));

    }

    public function icrProductDetails(Request $request){

        $data_id = $request -> data_id;

        $product_size_query = db::table('product_list')
            ->where('ID', $data_id)
            ->get();

        foreach($product_size_query as $data){
            $sizeData = $data -> SIZE;
        }

        return response()->json(array('size' => $sizeData));        

    }

    public function client_sales_invoice(Request $request){
        $data_id = $request -> client_id;
        $tableData2 = '';

        $sales_invoice = db::table('sales_invoice')
            ->where('CLIENT_ID', $data_id)
            ->get();

        foreach($sales_invoice as $data){
            $data0 = '<td> <input type="checkbox" id="radioButton"></td>';
            $data1 = '<td>'.$data -> INVOICE_NO.'</td>';
            $data2 = '<td>'.$data -> INVOICE_DATE.'</td>';
            $data3 = '<td>'.$data -> TOTAL .'</td>';

            $tableData2 .= '<tr class="text-center">'.$data0.' '.$data1.' '. $data2 .' '.$data3.' </tr>';
        }

        return response()->json(array('table_data2' => $tableData2));

    }

}
