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
    public function noValidate(Request $request){
        $buttonVal = $request -> buttonVal;
        $invoiceNo = $request -> invoiceNo;

        if($buttonVal == "invoice"){ // Invoice
           
            $si_assigned = db::table('si_assigned')
                ->join('sales_rep' , 'sales_rep.ID' , '=', 'si_assigned.SALESREP_ID')
                ->where('FROM_OR_NO', '<=', $invoiceNo)
                ->where('TO_OR_NO', '>=', $invoiceNo)
                ->get();

            $issuedBy = '';

            foreach($si_assigned as $issuerName){
                $issuedBy = $issuerName -> ASSIGNED_BY;
                $issuerID = $issuerName -> SALESREP_ID;
            }
            
           if($si_assigned->isEmpty() == false){

               $si_report = db::table('si_assigned_report')
                   ->where('INVOICE_NO', $invoiceNo)
                   ->where(function ($query){
                           $query->where('REMARKS', '=' , 'DONE')
                           ->orWhere('REMARKS', '=', 'CANCELLED')
                           ->orWhere('REMARKS', '=', 'NO RECORD FOUND');
                   })
                   ->get();
               if($si_report->isEmpty() == true){
                   return response()->json(array('issuedBy' => $issuedBy , 'issuerID' => $issuerID));
               }else{
                   foreach($si_report as $remarks){
                       return response()->json(array(['status' => $remarks->REMARKS ]));
                   }

               }

           }else{
                return Response()->json(['status' => 'empty']);
           }

        }else{ // For Button Recognitions

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

    }

}
