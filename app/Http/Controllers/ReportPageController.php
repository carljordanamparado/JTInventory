<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Arr;
use App;

class ReportPageController extends Controller
{
    //

    public function viewPricelistReport(){

    }

    public function viewStatementReport(){

        $option = '';

        $client = db::table('client')
            ->get();

        foreach($client as $data){
            $option .= '<option value="'.$data -> CLIENTID.'" data-id="'.$data->CLIENTID.'"> '.$data -> CLIENT_CODE.' - '.$data -> NAME .' </option>';
            $customer_name = $data -> NAME;
            $address = $data -> ADDRESS;
            $contact_person = $data -> CON_PERSON;
            $tel_no = $data -> TEL_NO;
        }

        return response()->json(array('option' => $option , 'cust_name' => $customer_name , 'address' => $address , 'cont_person' => $contact_person , 'tel_no' => $tel_no ));

    }

    public function statement_report(Request $request){

        $id = $request -> custDetails;
        $from_date = $request -> fromDate;
        $to_date = $request -> toDate;

        $data = db::table('sales_invoice')
            ->select('sales_invoice.INVOICE_NO AS REPORTNO','sales_invoice.INVOICE_DATE AS REPORTDATE',DB::raw('sales_invoice.TOTAL - sales_invoice.DOWNPAYMENT as TOTAL'),'sales_invoice_po.PO_NO')
            ->selectRaw('"INVOICE" as type')
            ->leftJoin('sales_invoice_po', 'sales_invoice.INVOICE_NO', '=', 'sales_invoice_po.INVOICE_NO')
            ->where('sales_invoice.STATUS', 1)
            ->where('sales_invoice.CLIENT_ID', $id)
            ->where('sales_invoice.FULLY_PAID', 0)
            ->whereBetween('sales_invoice.INVOICE_DATE', [$from_date , $to_date])
            ->get();

        $data2 = db::table('delivery_receipt as c')
            ->select('c.DR_NO AS REPORTNO','c.DR_DATE AS REPORTDATE', DB::raw('c.TOTAL - c.DOWNPAYMENT as TOTAL'),'d.PO_NO')
            ->selectRaw('"DR" as REPORTTYPE')
            ->leftJoin('delivery_receipt_po as d', 'c.DR_NO', '=' , 'd.DR_NO')
            ->where('c.STATUS', 1)
            ->where('c.CLIENT_ID', $id)
            ->where('c.FULLY_PAID', 0)
            ->whereBetween('c.DR_DATE', [$from_date , $to_date])
            ->orderByRaw(2)
            ->get();

        $qty = array();

        $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
        $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

        $C2H22 = 0;$AR2 = 0;$CO22 = 0;$IO22 = 0;$LPG2 = 0;
        $MO2F2 = 0; $MO2S2 = 0;$N22 = 0;$N202 = 0;$H2 = 0;$COMPMED2 = 0;


        // Delivery
        if(count($data) == 0 && count($data2) != 0){

            foreach($data2  as $val){

                $reportno = $val -> REPORTNO;
                $total = 0;

                $po_no = $val -> PO_NO;
                $reportdate = $val -> REPORTDATE;

                $product_deliver = db::table('delivery_receipt as a')
                    ->select('PRODUCT', 'SIZE', 'QTY', 'UNIT_PRICE')
                    ->leftJoin('delivery_receipt_order as b', 'a.DR_NO', '=', 'b.DR_NO')
                    ->where('a.DR_NO', $reportno)
                    ->get();


                for($i = 0; $i < count($product_deliver) ; $i++ ) {

                    $total += $product_deliver[$i] -> UNIT_PRICE;

                    if($product_deliver[$i] ->PRODUCT == "C2H2"){
                        $C2H2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "AR"){
                        $AR += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "CO2"){
                        $CO2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "IO2"){
                        $IO2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "LPG"){
                        $LPG += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "MO2"){
                        if($product_deliver[$i] -> SIZE == "FLASK"){
                            $MO2F += (int)$product_deliver[$i] -> QTY ;
                        }elseif($product_deliver[$i] -> SIZE == "STANDARD"){
                            $MO2S += (int)$product_deliver[$i] -> QTY ;
                        }
                    }
                    if($product_deliver[$i] ->PRODUCT == "N2"){
                        $N2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "N20"){
                        $N20 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "H"){
                        $H += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "COMPMED"){
                        $COMPMED += (int)$product_deliver[$i] -> QTY ;
                    }

                }

                $totalOther = 0;

                $dr_other_charges = db::table('dr_other_charges')
                    ->select('QUANTITY', 'UNIT_PRICE')
                    ->where('DR_NO', $reportno)
                    ->get();

                foreach($dr_other_charges as $other_price){
                    $totalOther = $totalOther + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                }


                $sales_invoice_report = array([
                    'INVOICE_NO' => $reportno,
                    'PO_NO' => $po_no,
                    'INVOICE_DATE' => $reportdate,
                    'C2H2' => $C2H2,
                    'AR' => $AR,
                    'CO2' => $CO2,
                    'IO2' => $IO2,
                    'LPG' => $LPG,
                    'MO2F' => $MO2F,
                    'MO2S' => $MO2S,
                    'N2' => $N2,
                    'N2O' => $N20,
                    'H' => $H,
                    'COMPMED' => $COMPMED,
                    'OTHER_CHARGES' => $totalOther,
                    'TOTAL' => $total,
                    'DR' => "DR"
                ]);

            }
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('data', "empty")
                ->with('data2', $sales_invoice_report);

        }
        // Sales Invoice
        if(count($data2) == 0 && count($data) != 0){
            foreach($data  as $val){

                $reportno2 = $val -> REPORTNO;
                $total2 = 0;

                $po_no = $val -> PO_NO;
                $reportdate = $val -> REPORTDATE;


                $prouct_sales = db::table('sales_invoice as a')
                    ->select('PRODUCT', 'SIZE', 'QTY', 'UNIT_PRICE')
                    ->leftjoin('sales_invoice_order as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
                    ->where('b.INVOICE_NO', $reportno2)
                    ->get();


                for($i = 0; $i < count($prouct_sales) ; $i++ ) {

                    $total2 += $prouct_sales[$i] -> UNIT_PRICE;

                    if($prouct_sales[$i] ->PRODUCT == "C2H2"){
                        $C2H22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "AR"){
                        $AR2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "CO2"){
                        $CO22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "IO2"){
                        $IO22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "LPG"){
                        $LPG2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "MO2"){
                        if($prouct_sales[$i] -> SIZE == "FLASK"){
                            $MO2F2 += (int)$prouct_sales[$i] -> QTY ;
                        }elseif($prouct_sales[$i] -> SIZE == "STANDARD"){
                            $MO2S2 += (int)$prouct_sales[$i] -> QTY ;
                        }
                    }
                    if($prouct_sales[$i] ->PRODUCT == "N2"){
                        $N22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "N20"){
                        $N202 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "H"){
                        $H2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "COMPMED"){
                        $COMPMED2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    /*
                                    $qty = arr::add($qty , 'C2H2', $C2H2);
                                    $qty = arr::add($qty , 'CO2', $CO2);
                                    $qty = arr::add($qty , 'AR', $AR);
                                    $qty = arr::add($qty , 'COMPMED', $COMPMED);
                                    $qty = arr::add($qty , 'H', $H);
                                    $qty = arr::add($qty , 'IO2', $IO2);
                                    $qty = arr::add($qty , 'LPG', $LPG);
                                    $qty = arr::add($qty , 'N2', $N2);
                                    $qty = arr::add($qty , 'MO2F', $MO2F);
                                    $qty = arr::add($qty , 'MO2S', $MO2S);
                                    $qty = arr::add($qty , 'N2O', $N20);*/

                }

                $totalOther2 = 0;

                $sales_other = db::table('other_charges')
                    ->select('QUANTITY', 'UNIT_PRICE')
                    ->where('INVOICE_NO', $reportno2)
                    ->get();

                foreach($sales_other as $other_price){
                    $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                }

                $sales_invoice_report2 = array([
                    'INVOICE_NO' => $reportno2,
                    'PO_NO' => $po_no,
                    'INVOICE_DATE' => $reportdate,
                    'C2H2' => $C2H22,
                    'AR' => $AR2,
                    'CO2' => $CO22,
                    'IO2' => $IO22,
                    'LPG' => $LPG2,
                    'MO2F' => $MO2F2,
                    'MO2S' => $MO2S2,
                    'N2' => $N22,
                    'N2O' => $N202,
                    'H' => $H2,
                    'COMPMED' => $COMPMED2,
                    'OTHER_CHARGES' => $totalOther2,
                    'TOTAL' => $total2,
                    'INVOICE'=> 'DR'
                ]);



            }
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('data2', "empty")
                ->with('data', $sales_invoice_report2);
        }
        // Empty Data
        if(count($data) == 0 && count($data2) == 0){
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('data2', "empty")
                ->with('data', "empty");
        }
        // Both
        if(count($data) != 0 && count($data2) != 0){
            foreach($data2  as $val){

                $reportno = $val -> REPORTNO;
                $total = 0;

                $po_no = $val -> PO_NO;
                $reportdate = $val -> REPORTDATE;

                $product_deliver = db::table('delivery_receipt as a')
                    ->select('PRODUCT', 'SIZE', 'QTY', 'UNIT_PRICE')
                    ->leftJoin('delivery_receipt_order as b', 'a.DR_NO', '=', 'b.DR_NO')
                    ->where('a.DR_NO', $reportno)
                    ->get();



                for($i = 0; $i < count($product_deliver) ; $i++ ) {

                    $total += $product_deliver[$i] -> UNIT_PRICE;

                    if($product_deliver[$i] ->PRODUCT == "C2H2"){
                        $C2H2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "AR"){
                        $AR += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "CO2"){
                        $CO2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "IO2"){
                        $IO2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "LPG"){
                        $LPG += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "MO2"){
                        if($product_deliver[$i] -> SIZE == "FLASK"){
                            $MO2F += (int)$product_deliver[$i] -> QTY ;
                        }elseif($product_deliver[$i] -> SIZE == "STANDARD"){
                            $MO2S += (int)$product_deliver[$i] -> QTY ;
                        }
                    }
                    if($product_deliver[$i] ->PRODUCT == "N2"){
                        $N2 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "N20"){
                        $N20 += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "H"){
                        $H += (int)$product_deliver[$i] -> QTY ;
                    }
                    if($product_deliver[$i] ->PRODUCT == "COMPMED"){
                        $COMPMED += (int)$product_deliver[$i] -> QTY ;
                    }

                }

                $totalOther = 0;

                $dr_other_charges = db::table('dr_other_charges')
                    ->select('QUANTITY', 'UNIT_PRICE')
                    ->where('DR_NO', $reportno)
                    ->get();

                foreach($dr_other_charges as $other_price){
                    $totalOther = $totalOther + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                }


                $sales_invoice_report = array([
                    'INVOICE_NO' => $reportno,
                    'PO_NO' => $po_no,
                    'INVOICE_DATE' => $reportdate,
                    'C2H2' => $C2H2,
                    'AR' => $AR,
                    'CO2' => $CO2,
                    'IO2' => $IO2,
                    'LPG' => $LPG,
                    'MO2F' => $MO2F,
                    'MO2S' => $MO2S,
                    'N2' => $N2,
                    'N2O' => $N20,
                    'H' => $H,
                    'COMPMED' => $COMPMED,
                    'OTHER_CHARGES' => $totalOther,
                    'TOTAL' => $total,
                    'DR' => "DR"
                ]);

            }

            foreach($data  as $val){

                $reportno2 = $val -> REPORTNO;
                $total2 = 0;

                $po_no = $val -> PO_NO;
                $reportdate = $val -> REPORTDATE;


                $prouct_sales = db::table('sales_invoice as a')
                    ->select('PRODUCT', 'SIZE', 'QTY', 'UNIT_PRICE')
                    ->leftjoin('sales_invoice_order as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
                    ->where('b.INVOICE_NO', $reportno2)
                    ->get();


                for($i = 0; $i < count($prouct_sales) ; $i++ ) {

                    $total2 += $prouct_sales[$i] -> UNIT_PRICE;

                    if($prouct_sales[$i] ->PRODUCT == "C2H2"){
                        $C2H22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "AR"){
                        $AR2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "CO2"){
                        $CO22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "IO2"){
                        $IO22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "LPG"){
                        $LPG2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "MO2"){
                        if($prouct_sales[$i] -> SIZE == "FLASK"){
                            $MO2F2 += (int)$prouct_sales[$i] -> QTY ;
                        }elseif($prouct_sales[$i] -> SIZE == "STANDARD"){
                            $MO2S2 += (int)$prouct_sales[$i] -> QTY ;
                        }
                    }
                    if($prouct_sales[$i] ->PRODUCT == "N2"){
                        $N22 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "N20"){
                        $N202 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "H"){
                        $H2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    if($prouct_sales[$i] ->PRODUCT == "COMPMED"){
                        $COMPMED2 += (int)$prouct_sales[$i] -> QTY ;
                    }
                    /*
                                    $qty = arr::add($qty , 'C2H2', $C2H2);
                                    $qty = arr::add($qty , 'CO2', $CO2);
                                    $qty = arr::add($qty , 'AR', $AR);
                                    $qty = arr::add($qty , 'COMPMED', $COMPMED);
                                    $qty = arr::add($qty , 'H', $H);
                                    $qty = arr::add($qty , 'IO2', $IO2);
                                    $qty = arr::add($qty , 'LPG', $LPG);
                                    $qty = arr::add($qty , 'N2', $N2);
                                    $qty = arr::add($qty , 'MO2F', $MO2F);
                                    $qty = arr::add($qty , 'MO2S', $MO2S);
                                    $qty = arr::add($qty , 'N2O', $N20);*/

                }

                $totalOther2 = 0;

                $sales_other = db::table('other_charges')
                    ->select('QUANTITY', 'UNIT_PRICE')
                    ->where('INVOICE_NO', $reportno2)
                    ->get();

                foreach($sales_other as $other_price){
                    $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                }

                $sales_invoice_report2 = array([
                    'INVOICE_NO' => $reportno2,
                    'PO_NO' => $po_no,
                    'INVOICE_DATE' => $reportdate,
                    'C2H2' => $C2H22,
                    'AR' => $AR2,
                    'CO2' => $CO22,
                    'IO2' => $IO22,
                    'LPG' => $LPG2,
                    'MO2F' => $MO2F2,
                    'MO2S' => $MO2S2,
                    'N2' => $N22,
                    'N2O' => $N202,
                    'H' => $H2,
                    'COMPMED' => $COMPMED2,
                    'OTHER_CHARGES' => $totalOther2,
                    'TOTAL' => $total2,
                    'INVOICE'=> 'DR'
                ]);



            }

            return view('Reports.CustomerReports.Reporting.statement')
                ->with('data2', $sales_invoice_report)
                ->with('data', $sales_invoice_report2);
        }

        /*$pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('Reports.CustomerReports.Reporting.statement', ['data2' => $data2]);
        return $pdf->stream();*/

    }

    public function aging_account(Request $request){

        $id = $request -> custDetails;
        $from_date = $request -> fromDate;
        $to_date = $request -> toDate;

        $sales_data = db::table('sales_invoice')
            ->select(db::raw('DATEDIFF(CURDATE(),INVOICE_DATE) as AGING'),'INVOICE_DATE as REPORTDATE','INVOICE_NO as REPORTNO', 'BALANCE')
            ->where('STATUS', 1)
            ->where('CLIENT_ID', $id)
            ->where('FULLY_PAID', 0)
            ->whereBetween('INVOICE_DATE',[$from_date, $to_date]);

        $dr_data = db::table('delivery_receipt')
            ->select(db::raw('DATEDIFF(CURDATE(),DR_DATE) as AGING'),'DR_DATE as REPORTDATE','DR_NO as REPORTNO','BALANCE')
            ->where('STATUS', 1)
            ->where('CLIENT_ID', $id)
            ->where('FULLY_PAID', 0)
            ->whereBetween('DR_DATE',[$from_date, $to_date])
            ->unionAll($sales_data)
            ->paginate(20);

        return view('Reports.CustomerReports.Reporting.agingacccount')
            ->with('Aging', $dr_data);

    }

}
