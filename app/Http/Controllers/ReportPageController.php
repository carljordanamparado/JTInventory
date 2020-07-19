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
            ->where('STATUS', '1')
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
        $to_date =$request -> toDate;

        db::table('statement_account')->truncate();


        $sales_invoice = db::table('sales_invoice as a')
            ->select('a.INVOICE_NO as REPORTNO', 'a.INVOICE_DATE as REPORTDATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO')
            ->selectRaw(" 'INVOICE' as TYPE")
            ->join('sales_invoice_po as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
            ->where('a.CLIENT_ID', $id)
            ->where('a.STATUS', "1")
            ->where('a.FULLY_PAID', "0")
            ->whereBetween('a.INVOICE_DATE', [$from_date, $to_date]);

        $delivery = db::table('delivery_receipt as a')
            ->select('a.DR_NO as REPORTNO', 'a.DR_DATE as REPORTDATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO')
            ->selectRaw(" 'DR' as TYPE")
            ->join('delivery_receipt_po as b', 'a.DR_NO', '=', 'b.DR_NO')
            ->where('a.CLIENT_ID', $id)
            ->where('a.STATUS', "1")
            ->where('a.AS_INVOICE', "1")
            ->where('a.FULLY_PAID', "0")
            ->whereBetween('a.DR_DATE', [$from_date, $to_date])
            ->unionAll($sales_invoice)
            ->get();

        foreach($delivery as $data){

            if($data -> TYPE == "INVOICE"){

                $sales_product = db::table('sales_invoice_order')
                    ->where('INVOICE_NO', $data -> REPORTNO)
                    ->get();

                $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
                $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

                foreach($sales_product as $product){

                    if($product ->PRODUCT == "C2H2" || $product ->PRODUCT == "ACETYLENE"){
                        $C2H2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "AR" || $product ->PRODUCT == "ARGON"){
                        $AR +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "CO2" || $product ->PRODUCT == "CARBON DIOXIDE"){
                        $CO2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "IO2" || $product ->PRODUCT == "INDUSTRIAL OXYGEN"){
                        $IO2 +=  (int)$product -> QTY ;
                    }
                    if($product -> PRODUCT == "LPG"){
                        $LPG +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "MO2" || $product ->PRODUCT == "MEDICAL OXYGEN"){
                        if($product -> SIZE == "FLASK"){
                            $MO2F += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $MO2S += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "N2" || $product ->PRODUCT == "NITROGEN"){
                        $N2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "N20" || $product ->PRODUCT == "NITROUS OXIDE"){
                        $N20 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "H" || $product ->PRODUCT == "HYDROGEN"){
                        $H +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "COMPMED" || $product ->PRODUCT == "COMPRESSED AIR"){
                        $COMPMED +=  (int)$product -> QTY ;
                    }

                    $totalOther2 = 0;

                    $sales_other = db::table('other_charges')
                        ->select('QUANTITY', 'UNIT_PRICE')
                        ->where('INVOICE_NO', $product -> INVOICE_NO)
                        ->get();

                    foreach($sales_other as $other_price){
                        $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                    }

                }

                $sales_invoice_report = array([
                    'INVOICE_NO' => $data -> REPORTNO,
                    'INVOICE_DATE' => $data -> REPORTDATE,
                    'PO_NO' => $data -> PO_NO,
                    'C2H2'  => $C2H2,
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
                    'TOTAL' => $data -> TOTAL + $totalOther2
                ]);

                db::table('statement_account')
                    ->insert($sales_invoice_report);

            }elseif($data->TYPE == "DR"){

                $delivery_product = db::table('delivery_receipt_order')
                    ->where('INVOICE_NO', $data -> REPORTNO)
                    ->get();

                $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
                $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

                foreach($delivery_product as $product){

                    if($product ->PRODUCT == "C2H2" || $product ->PRODUCT == "ACETYLENE"){
                        $C2H2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "AR" || $product ->PRODUCT == "ARGON"){
                        $AR +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "CO2" || $product ->PRODUCT == "CARBON DIOXIDE"){
                        $CO2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "IO2" || $product ->PRODUCT == "INDUSTRIAL OXYGEN"){
                        $IO2 +=  (int)$product -> QTY ;
                    }
                    if($product -> PRODUCT == "LPG"){
                        $LPG +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "MO2" || $product ->PRODUCT == "MEDICAL OXYGEN"){
                        if($product -> SIZE == "FLASK"){
                            $MO2F += (int)$product -> QTY ;
                        }elseif($product -> SIZE == "STANDARD"){
                            $MO2S += (int)$product -> QTY ;
                        }
                    }
                    if($product ->PRODUCT == "N2" || $product ->PRODUCT == "NITROGEN"){
                        $N2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "N20" || $product ->PRODUCT == "NITROUS OXIDE"){
                        $N20 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "H" || $product ->PRODUCT == "HYDROGEN"){
                        $H +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "COMPMED" || $product ->PRODUCT == "COMPRESSED AIR"){
                        $COMPMED +=  (int)$product -> QTY ;
                    }

                    $totalOther2 = 0;

                    $sales_other = db::table('other_charges')
                        ->select('QUANTITY', 'UNIT_PRICE')
                        ->where('INVOICE_NO', $product -> INVOICE_NO)
                        ->get();

                    foreach($sales_other as $other_price){
                        $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                    }

                }

                $sales_invoice_report = array([
                    'INVOICE_NO' => $data -> REPORTNO,
                    'INVOICE_DATE' => $data -> REPORTDATE,
                    'PO_NO' => $data -> PO_NO,
                    'C2H2'  => $C2H2,
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
                    'TOTAL' => $data -> TOTAL + $totalOther2
                ]);

                db::table('statement_account')
                    ->insert($sales_invoice_report);
            }

        }

        $statement = db::table('statement_account')
            ->get();

        return view('Reports.CustomerReports.Reporting.statement')
           ->with('statement', $statement);

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
            ->get();


        return view('Reports.CustomerReports.Reporting.agingacccount')
            ->with('Aging', $dr_data);
    }

    public function summary_account(Request $request){
        $id = $request -> custDetails;

        DB::table('summary_account')->truncate();

        $sales_invoice = db::table('sales_invoice as a')
            ->select('a.INVOICE_NO as REPORTNO', 'a.INVOICE_DATE as REPORTDATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO')
            ->selectRaw(" 'INVOICE' as TYPE")
            ->join('sales_invoice_po as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
            ->where('a.CLIENT_ID', $id)
            ->where('a.STATUS', "1")
            ->where('a.FULLY_PAID', "0");

        $delivery = db::table('delivery_receipt as a')
            ->select('a.DR_NO as REPORTNO', 'a.DR_DATE as REPORTDATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO')
            ->selectRaw(" 'DR' as TYPE")
            ->join('delivery_receipt_po as b', 'a.DR_NO', '=', 'b.DR_NO')
            ->where('a.CLIENT_ID', $id)
            ->where('a.STATUS', "1")
            ->where('a.AS_INVOICE', "1")
            ->where('a.FULLY_PAID', "0")
            ->unionAll($sales_invoice)
            ->get();

        foreach($delivery as $data){

            if($data -> TYPE == "INVOICE"){

                $sales_product = db::table('sales_invoice_order')
                    ->where('INVOICE_NO', $data -> REPORTNO)
                    ->get();

                $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
                $MO2 = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

                foreach($sales_product as $product){

                    if($product ->PRODUCT == "C2H2" || $product ->PRODUCT == "ACETYLENE"){
                        $C2H2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "AR" || $product ->PRODUCT == "ARGON"){
                        $AR +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "CO2" || $product ->PRODUCT == "CARBON DIOXIDE"){
                        $CO2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "IO2" || $product ->PRODUCT == "INDUSTRIAL OXYGEN"){
                        $IO2 +=  (int)$product -> QTY ;
                    }
                    if($product -> PRODUCT == "LPG"){
                        $LPG +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "MO2" || $product ->PRODUCT == "MEDICAL OXYGEN"){
                        $MO2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "N2" || $product ->PRODUCT == "NITROGEN"){
                        $N2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "N20" || $product ->PRODUCT == "NITROUS OXIDE"){
                        $N20 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "H" || $product ->PRODUCT == "HYDROGEN"){
                        $H +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "COMPMED" || $product ->PRODUCT == "COMPRESSED AIR"){
                        $COMPMED +=  (int)$product -> QTY ;
                    }

                    $totalOther2 = 0;

                    $sales_other = db::table('other_charges')
                        ->select('QUANTITY', 'UNIT_PRICE')
                        ->where('INVOICE_NO', $product -> INVOICE_NO)
                        ->get();

                    foreach($sales_other as $other_price){
                        $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                    }

                }

                    $sales_invoice_report = array([
                        'INVOICE_NO' => $data -> REPORTNO,
                        'INVOICE_DATE' => $data -> REPORTDATE,
                        'PO_NO' => $data -> PO_NO,
                        'C2H2'  => $C2H2,
                        'AR' => $AR,
                        'CO2' => $CO2,
                        'IO2' => $IO2,
                        'LPG' => $LPG,
                        'MO2' => $MO2,
                        'N2' => $N2,
                        'N2O' => $N20,
                        'H' => $H,
                        'COMPMED' => $COMPMED,
                        'OTHER_CHARGES' => $totalOther2,
                        'TOTAL' => $data -> TOTAL
                    ]);

                    db::table('summary_account')
                        ->insert($sales_invoice_report);

            }elseif($data->TYPE == "DR"){

                $delivery_product = db::table('delivery_receipt_order')
                    ->where('INVOICE_NO', $data -> REPORTNO)
                    ->get();

                $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
                $MO2 = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

                foreach($delivery_product as $product){

                    if($product ->PRODUCT == "C2H2" || $product ->PRODUCT == "ACETYLENE"){
                        $C2H2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "AR" || $product ->PRODUCT == "ARGON"){
                        $AR +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "CO2" || $product ->PRODUCT == "CARBON DIOXIDE"){
                        $CO2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "IO2" || $product ->PRODUCT == "INDUSTRIAL OXYGEN"){
                        $IO2 +=  (int)$product -> QTY ;
                    }
                    if($product -> PRODUCT == "LPG"){
                        $LPG +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "MO2" || $product ->PRODUCT == "MEDICAL OXYGEN"){
                        $MO2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "N2" || $product ->PRODUCT == "NITROGEN"){
                        $N2 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "N20" || $product ->PRODUCT == "NITROUS OXIDE"){
                        $N20 +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "H" || $product ->PRODUCT == "HYDROGEN"){
                        $H +=  (int)$product -> QTY ;
                    }
                    if($product ->PRODUCT == "COMPMED" || $product ->PRODUCT == "COMPRESSED AIR"){
                        $COMPMED +=  (int)$product -> QTY ;
                    }

                    $totalOther2 = 0;

                    $sales_other = db::table('other_charges')
                        ->select('QUANTITY', 'UNIT_PRICE')
                        ->where('INVOICE_NO', $product -> INVOICE_NO)
                        ->get();

                    foreach($sales_other as $other_price){
                        $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
                    }

                }

                $sales_invoice_report = array([
                    'INVOICE_NO' => $data -> REPORTNO,
                    'INVOICE_DATE' => $data -> REPORTDATE,
                    'PO_NO' => $data -> PO_NO,
                    'C2H2'  => $C2H2,
                    'AR' => $AR,
                    'CO2' => $CO2,
                    'IO2' => $IO2,
                    'LPG' => $LPG,
                    'MO2' => $MO2,
                    'N2' => $N2,
                    'N2O' => $N20,
                    'H' => $H,
                    'COMPMED' => $COMPMED,
                    'OTHER_CHARGES' => $totalOther2,
                    'TOTAL' => $data -> TOTAL
                ]);

                db::table('summary_account')
                    ->insert($sales_invoice_report);
            }

        }

         $summary_account = db::table('summary_account')
             ->get();

        return view('Reports.CustomerReports.Reporting.summary')
            ->with('summary_account', $summary_account);



    }

    public function statement_cylinder(Request $request){
        $id = $request -> custDetails;

        DB::table('summary_cylinder_balance_report')->truncate();

        $C2H2_PRESTOLITE_BAL = 0;
        $C2H2_MEDIUM_BAL = 0;
        $C2H2_STANDARD_BAL = 0;
        $AR_STANDARD_BAL = 0;
        $CO2_FLASK_BAL = 0;
        $CO2_STANDARD_BAL = 0;
        $IO2_FLASK_BAL = 0;
        $IO2_MEDIUM_BAL = 0;
        $IO2_STANDARD_BAL = 0;
        $LPG_11KG_BAL = 0;
        $LPG_22KG_BAL = 0;
        $LPG_50KG_BAL = 0;
        $MO2_FLASK_BAL = 0;
        $MO2_MEDIUM_BAL = 0;
        $MO2_STANDARD_BAL = 0;
        $N2_FLASK_BAL = 0;
        $N2_STANDARD_BAL = 0;
        $N2O_FLASK_BAL = 0;
        $N2O_STANDARD_BAL = 0;
        $H_STANDARD_BAL = 0;
        $COMPMED_STANDARD_BAL = 0;

        $query1 = db::table('delivery_new as a')
            ->join('cylinder_loan_contract as b', 'a.CLC_NO', '=', 'b.CLC_NO')
            ->where('b.CLIENT_NO', $id)
            ->orderBy('a.INVOICE_DATE')
            ->get();

        foreach($query1 as $query1){

            $C2H2_PRESTOLITE_BAL = $C2H2_PRESTOLITE_BAL + $query1 -> C2H2_PRESTOLITE;
            $C2H2_MEDIUM_BAL = $C2H2_MEDIUM_BAL + $query1 -> C2H2_MEDIUM;
            $C2H2_STANDARD_BAL = $C2H2_STANDARD_BAL + $query1 -> C2H2_STANDARD;
            $AR_STANDARD_BAL = $AR_STANDARD_BAL + $query1 -> AR_STANDARD;
            $CO2_FLASK_BAL = $CO2_FLASK_BAL + $query1 -> CO2_FLASK;
            $CO2_STANDARD_BAL = $CO2_STANDARD_BAL + $query1 -> CO2_STANDARD;
            $IO2_FLASK_BAL = $IO2_FLASK_BAL + $query1 -> IO2_FLASK;
            $IO2_MEDIUM_BAL = $IO2_MEDIUM_BAL + $query1 -> IO2_MEDIUM;
            $IO2_STANDARD_BAL = $IO2_STANDARD_BAL + $query1 -> IO2_STANDARD;
            $LPG_11KG_BAL = $LPG_11KG_BAL + $query1 -> LPG_11KG;
            $LPG_22KG_BAL = $LPG_22KG_BAL + $query1 -> LPG_22KG;
            $LPG_50KG_BAL = $LPG_50KG_BAL + $query1 -> LPG_50KG;
            $MO2_FLASK_BAL = $MO2_FLASK_BAL + $query1 -> MO2_FLASK;
            $MO2_MEDIUM_BAL = $MO2_MEDIUM_BAL + $query1 -> MO2_MEDIUM;
            $MO2_STANDARD_BAL = $MO2_STANDARD_BAL + $query1 -> MO2_STANDARD;
            $N2_FLASK_BAL = $N2_FLASK_BAL + $query1 -> N2_FLASK;
            $N2_STANDARD_BAL = $N2_STANDARD_BAL + $query1 -> N2_STANDARD;
            $N2O_FLASK_BAL = $N2O_FLASK_BAL + $query1 -> N2O_FLASK;
            $N2O_STANDARD_BAL = $N2O_STANDARD_BAL + $query1 -> N2O_STANDARD;
            $H_STANDARD_BAL = $H_STANDARD_BAL + $query1 -> H_STANDARD;
            $COMPMED_STANDARD_BAL = $COMPMED_STANDARD_BAL + $query1 -> COMPMED_STANDARD;

            $query_1_data = array([
                'INVOICE_NO' => $query1 -> INVOICE_NO,
                'INVOICE_DATE' => $query1 -> INVOICE_DATE,
                'ICR_NO' =>$query1 -> ICR_NO,
                'CLC_NO'  => $query1 -> CLC_NO,
                'C2H2_PRESTOLITE_DELIVER' => $query1 -> C2H2_PRESTOLITE,
                'C2H2_PRESTOLITE_BALANCE' => $C2H2_PRESTOLITE_BAL,
                'C2H2_MEDIUM_DELIVER' => $query1 -> C2H2_MEDIUM,
                'C2H2_MEDIUM_BALANCE' => $C2H2_MEDIUM_BAL,
                'C2H2_STANDARD_DELIVER' => $query1 -> C2H2_STANDARD,
                'C2H2_STANDARD_BALANCE' => $C2H2_STANDARD_BAL,
                'AR_STANDARD_DELIVER' => $query1 -> AR_STANDARD,
                'AR_STANDARD_BALANCE' => $AR_STANDARD_BAL,
                'CO2_FLASK_DELIVER' => $query1->CO2_FLASK,
                'CO2_FLASK_BALANCE' => $CO2_FLASK_BAL,
                'CO2_STANDARD_DELIVER' => $query1 -> CO2_STANDARD,
                'CO2_STANDARD_BALANCE' => $CO2_STANDARD_BAL,
                'IO2_FLASK_DELIVER' => $query1 -> IO2_FLASK,
                'IO2_FLASK_BALANCE' => $IO2_FLASK_BAL,
                'IO2_MEDIUM_DELIVER' => $query1 -> IO2_MEDIUM,
                'IO2_MEDIUM_BALANCE' => $IO2_MEDIUM_BAL,
                'IO2_STANDARD_DELIVER' => $query1 -> IO2_STANDARD,
                'IO2_STANDARD_BALANCE' => $IO2_STANDARD_BAL,
                'LPG_11KG_DELIVER' => $query1 -> LPG_11KG,
                'LPG_11KG_BALANCE' => $LPG_11KG_BAL,
                'LPG_22KG_DELIVER' => $query1 -> LPG_22KG,
                'LPG_22KG_BALANCE' => $LPG_22KG_BAL,
                'LPG_50KG_DELIVER' => $query1 -> LPG_50KG,
                'LPG_50KG_BALANCE' => $LPG_50KG_BAL,
                'MO2_FLASK_DELIVER' => $query1 -> MO2_FLASK,
                'MO2_FLASK_BALANCE' => $MO2_FLASK_BAL,
                'MO2_MEDIUM_DELIVER' => $query1 -> MO2_MEDIUM,
                'MO2_MEDIUM_BALANCE' => $MO2_MEDIUM_BAL,
                'MO2_STANDARD_DELIVER' => $query1 -> MO2_STANDARD,
                'MO2_STANDARD_BALANCE' => $MO2_STANDARD_BAL,
                'N2_FLASK_DELIVER' => $query1 -> N2_FLASK,
                'N2_FLASK_BALANCE' => $N2_FLASK_BAL,
                'N2_STANDARD_DELIVER' => $query1 -> N2_STANDARD,
                'N2_STANDARD_BALANCE' => $N2_STANDARD_BAL,
                'N2O_FLASK_DELIVER' => $query1 -> N2O_FLASK,
                'N2O_FLASK_BALANCE' => $N2O_FLASK_BAL,
                'N2O_STANDARD_DELIVER' => $query1 -> N2O_STANDARD,
                'N2O_STANDARD_BALANCE' => $N2O_STANDARD_BAL,
                'H_STANDARD_DELIVER' => $query1 -> H_STANDARD,
                'H_STANDARD_BALANCE' => $H_STANDARD_BAL,
                'COMPMED_STANDARD_DELIVER' => $query1 -> COMPMED_STANDARD,
                'COMPMED_STANDARD_BALANCE' => $COMPMED_STANDARD_BAL
            ]);

            db::table('summary_cylinder_balance_report')
                ->insert($query_1_data);

            $query2 = db::table('sales_invoice as a')
                ->where('a.CLIENT_ID', $id)
                ->where('a.INVOICE_DATE', '>=', $query1 -> INVOICE_DATE)
                ->orderBy('a.INVOICE_DATE', 'ASC')
                ->get();

            if($query2->isEmpty()){

            }else{
                foreach($query2 as $row2){
                    $query111 = db::table('cylinder_loan_contract as a')
                        ->where('a.INVOICE', $row2 -> INVOICE_NO)
                        ->where('a.CLIENT_NO', $id)
                        ->orderBy('a.CLC_DATE', 'ASC')
                        ->get();

                    if($query2->count() > 1){

                    }else{
                        foreach($query111 as $row112){
                            if($row112 -> CLC_NO != $query1->CLC_NO){

                                $query3 = db::table('delivery_new as a')
                                    ->where('a.INVOICE_NO', $row2 -> INVOICE_NO)
                                    ->where('a.INVOICE_DATE', $row2 -> INVOICE_DATE)
                                    ->get();

                                if($query3 ->isEmpty()){

                                }else{
                                    foreach($query3 as $row3){
                                        $C2H2_PRESTOLITE_BAL = $C2H2_PRESTOLITE_BAL + $row3 -> C2H2_PRESTOLITE;
                                        $C2H2_MEDIUM_BAL = $C2H2_MEDIUM_BAL + $row3 -> C2H2_MEDIUM;
                                        $C2H2_STANDARD_BAL = $C2H2_STANDARD_BAL + $row3 -> C2H2_STANDARD;
                                        $AR_STANDARD_BAL = $AR_STANDARD_BAL + $row3 -> AR_STANDARD;
                                        $CO2_FLASK_BAL = $CO2_FLASK_BAL + $row3 -> CO2_FLASK;
                                        $CO2_STANDARD_BAL = $CO2_STANDARD_BAL + $row3 -> CO2_STANDARD;
                                        $IO2_FLASK_BAL = $IO2_FLASK_BAL + $row3 -> IO2_FLASK;
                                        $IO2_MEDIUM_BAL = $IO2_MEDIUM_BAL + $row3 -> IO2_MEDIUM;
                                        $IO2_STANDARD_BAL = $IO2_STANDARD_BAL + $row3 -> IO2_STANDARD;
                                        $LPG_11KG_BAL = $LPG_11KG_BAL + $row3 -> LPG_11KG;
                                        $LPG_22KG_BAL = $LPG_22KG_BAL + $row3 -> LPG_22KG;
                                        $LPG_50KG_BAL = $LPG_50KG_BAL + $row3 -> LPG_50KG;
                                        $MO2_FLASK_BAL = $MO2_FLASK_BAL + $row3 -> MO2_FLASK;
                                        $MO2_MEDIUM_BAL = $MO2_MEDIUM_BAL + $row3 -> MO2_MEDIUM;
                                        $MO2_STANDARD_BAL = $MO2_STANDARD_BAL + $row3 -> MO2_STANDARD;
                                        $N2_FLASK_BAL = $N2_FLASK_BAL + $row3 -> N2_FLASK;
                                        $N2_STANDARD_BAL = $N2_STANDARD_BAL + $row3 -> N2_STANDARD;
                                        $N2O_FLASK_BAL = $N2O_FLASK_BAL + $row3 -> N2O_FLASK;
                                        $N2O_STANDARD_BAL = $N2O_STANDARD_BAL + $row3 -> N2O_STANDARD;
                                        $H_STANDARD_BAL = $H_STANDARD_BAL + $row3 -> H_STANDARD;
                                        $COMPMED_STANDARD_BAL = $COMPMED_STANDARD_BAL + $row3 -> COMPMED_STANDARD;

                                        $query_2_data = array([
                                            'INVOICE_NO' => $row3 -> INVOICE_NO,
                                            'INVOICE_DATE' => $row3 -> INVOICE_DATE,
                                            'ICR_NO' =>$row3 -> ICR_NO,
                                            'CLC_NO'  => $row3 -> CLC_NO,
                                            'C2H2_PRESTOLITE_DELIVER' => $row3 -> C2H2_PRESTOLITE,
                                            'C2H2_PRESTOLITE_BALANCE' => $C2H2_PRESTOLITE_BAL,
                                            'C2H2_MEDIUM_DELIVER' => $row3 -> C2H2_MEDIUM,
                                            'C2H2_MEDIUM_BALANCE' => $C2H2_MEDIUM_BAL,
                                            'C2H2_STANDARD_DELIVER' => $row3 -> C2H2_STANDARD,
                                            'C2H2_STANDARD_BALANCE' => $C2H2_STANDARD_BAL,
                                            'AR_STANDARD_DELIVER' => $row3 -> AR_STANDARD,
                                            'AR_STANDARD_BALANCE' => $AR_STANDARD_BAL,
                                            'CO2_FLASK_DELIVER' => $row3->CO2_FLASK,
                                            'CO2_FLASK_BALANCE' => $CO2_FLASK_BAL,
                                            'CO2_STANDARD_DELIVER' => $row3 -> CO2_STANDARD,
                                            'CO2_STANDARD_BALANCE' => $CO2_STANDARD_BAL,
                                            'IO2_FLASK_DELIVER' => $row3 -> IO2_FLASK,
                                            'IO2_FLASK_BALANCE' => $IO2_FLASK_BAL,
                                            'IO2_MEDIUM_DELIVER' => $row3 -> IO2_MEDIUM,
                                            'IO2_MEDIUM_BALANCE' => $IO2_MEDIUM_BAL,
                                            'IO2_STANDARD_DELIVER' => $row3 -> IO2_STANDARD,
                                            'IO2_STANDARD_BALANCE' => $IO2_STANDARD_BAL,
                                            'LPG_11KG_DELIVER' => $row3 -> LPG_11KG,
                                            'LPG_11KG_BALANCE' => $LPG_11KG_BAL,
                                            'LPG_22KG_DELIVER' => $row3 -> LPG_22KG,
                                            'LPG_22KG_BALANCE' => $LPG_22KG_BAL,
                                            'LPG_50KG_DELIVER' => $row3 -> LPG_50KG,
                                            'LPG_50KG_BALANCE' => $LPG_50KG_BAL,
                                            'MO2_FLASK_DELIVER' => $row3 -> MO2_FLASK,
                                            'MO2_FLASK_BALANCE' => $MO2_FLASK_BAL,
                                            'MO2_MEDIUM_DELIVER' => $row3 -> MO2_MEDIUM,
                                            'MO2_MEDIUM_BALANCE' => $MO2_MEDIUM_BAL,
                                            'MO2_STANDARD_DELIVER' => $row3 -> MO2_STANDARD,
                                            'MO2_STANDARD_BALANCE' => $MO2_STANDARD_BAL,
                                            'N2_FLASK_DELIVER' => $row3 -> N2_FLASK,
                                            'N2_FLASK_BALANCE' => $N2_FLASK_BAL,
                                            'N2_STANDARD_DELIVER' => $row3 -> N2_STANDARD,
                                            'N2_STANDARD_BALANCE' => $N2_STANDARD_BAL,
                                            'N2O_FLASK_DELIVER' => $row3 -> N2O_FLASK,
                                            'N2O_FLASK_BALANCE' => $N2O_FLASK_BAL,
                                            'N2O_STANDARD_DELIVER' => $row3 -> N2O_STANDARD,
                                            'N2O_STANDARD_BALANCE' => $N2O_STANDARD_BAL,
                                            'H_STANDARD_DELIVER' => $row3 -> H_STANDARD,
                                            'H_STANDARD_BALANCE' => $H_STANDARD_BAL,
                                            'COMPMED_STANDARD_DELIVER' => $row3 -> COMPMED_STANDARD,
                                            'COMPMED_STANDARD_BALANCE' => $COMPMED_STANDARD_BAL
                                        ]);

                                        db::table('summary_cylinder_balance_report')
                                            ->insert($query_2_data);
                                    }
                                }
                            }
                            $query5 = db::table('pickup_new as a')
                                ->where('a.INVOICE', $row2 -> INVOICE_NO)
                                ->where('a.INVOICE_DATE', $row2 -> INVOICE_DATE)
                                ->get();

                            if($query5 -> isEmpty()){

                            }else{

                                foreach($query5 as $row4){
                                    $C2H2_PRESTOLITE_BAL = $C2H2_PRESTOLITE_BAL - $row4 -> C2H2_PRESTOLITE;
                                    $C2H2_MEDIUM_BAL = $C2H2_MEDIUM_BAL - $row4 -> C2H2_MEDIUM;
                                    $C2H2_STANDARD_BAL = $C2H2_STANDARD_BAL - $row4 -> C2H2_STANDARD;
                                    $AR_STANDARD_BAL = $AR_STANDARD_BAL - $row4 -> AR_STANDARD;
                                    $CO2_FLASK_BAL = $CO2_FLASK_BAL - $row4 -> CO2_FLASK;
                                    $CO2_STANDARD_BAL = $CO2_STANDARD_BAL - $row4 -> CO2_STANDARD;
                                    $IO2_FLASK_BAL = $IO2_FLASK_BAL - $row4 -> IO2_FLASK;
                                    $IO2_MEDIUM_BAL = $IO2_MEDIUM_BAL - $row4 -> IO2_MEDIUM;
                                    $IO2_STANDARD_BAL = $IO2_STANDARD_BAL - $row4 -> IO2_STANDARD;
                                    $LPG_11KG_BAL = $LPG_11KG_BAL - $row4 -> LPG_11KG;
                                    $LPG_22KG_BAL = $LPG_22KG_BAL - $row4 -> LPG_22KG;
                                    $LPG_50KG_BAL = $LPG_50KG_BAL - $row4 -> LPG_50KG;
                                    $MO2_FLASK_BAL = $MO2_FLASK_BAL - $row4 -> MO2_FLASK;
                                    $MO2_MEDIUM_BAL = $MO2_MEDIUM_BAL - $row4 -> MO2_MEDIUM;
                                    $MO2_STANDARD_BAL = $MO2_STANDARD_BAL - $row4 -> MO2_STANDARD;
                                    $N2_FLASK_BAL = $N2_FLASK_BAL - $row4 -> N2_FLASK;
                                    $N2_STANDARD_BAL = $N2_STANDARD_BAL - $row4 -> N2_STANDARD;
                                    $N2O_FLASK_BAL = $N2O_FLASK_BAL - $row4 -> N2O_FLASK;
                                    $N2O_STANDARD_BAL = $N2O_STANDARD_BAL - $row4 -> N2O_STANDARD;
                                    $H_STANDARD_BAL = $H_STANDARD_BAL - $row4 -> H_STANDARD;
                                    $COMPMED_STANDARD_BAL = $COMPMED_STANDARD_BAL - $row4 -> COMPMED_STANDARD;

                                    $query_3_data = array([
                                        'INVOICE_NO' => $row4 -> INVOICE_NO,
                                        'INVOICE_DATE' => $row4 -> INVOICE_DATE,
                                        'ICR_NO' =>$row4 -> ICR_NO,
                                        'CLC_NO'  => $row4 -> CLC_NO,
                                        'C2H2_PRESTOLITE_PICKUP' => $row4 -> C2H2_PRESTOLITE,
                                        'C2H2_PRESTOLITE_BALANCE' => $C2H2_PRESTOLITE_BAL,
                                        'C2H2_MEDIUM_PICKUP' => $row4 -> C2H2_MEDIUM,
                                        'C2H2_MEDIUM_BALANCE' => $C2H2_MEDIUM_BAL,
                                        'C2H2_STANDARD_PICKUP' => $row4 -> C2H2_STANDARD,
                                        'C2H2_STANDARD_BALANCE' => $C2H2_STANDARD_BAL,
                                        'AR_STANDARD_PICKUP' => $row4 -> AR_STANDARD,
                                        'AR_STANDARD_BALANCE' => $AR_STANDARD_BAL,
                                        'CO2_FLASK_PICKUP' => $row4->CO2_FLASK,
                                        'CO2_FLASK_BALANCE' => $CO2_FLASK_BAL,
                                        'CO2_STANDARD_PICKUP' => $row4 -> CO2_STANDARD,
                                        'CO2_STANDARD_BALANCE' => $CO2_STANDARD_BAL,
                                        'IO2_FLASK_PICKUP' => $row4 -> IO2_FLASK,
                                        'IO2_FLASK_BALANCE' => $IO2_FLASK_BAL,
                                        'IO2_MEDIUM_PICKUP' => $row4 -> IO2_MEDIUM,
                                        'IO2_MEDIUM_BALANCE' => $IO2_MEDIUM_BAL,
                                        'IO2_STANDARD_PICKUP' => $row4 -> IO2_STANDARD,
                                        'IO2_STANDARD_BALANCE' => $IO2_STANDARD_BAL,
                                        'LPG_11KG_PICKUP' => $row4 -> LPG_11KG,
                                        'LPG_11KG_BALANCE' => $LPG_11KG_BAL,
                                        'LPG_22KG_PICKUP' => $row4 -> LPG_22KG,
                                        'LPG_22KG_BALANCE' => $LPG_22KG_BAL,
                                        'LPG_50KG_PICKUP' => $row4 -> LPG_50KG,
                                        'LPG_50KG_BALANCE' => $LPG_50KG_BAL,
                                        'MO2_FLASK_PICKUP' => $row4 -> MO2_FLASK,
                                        'MO2_FLASK_BALANCE' => $MO2_FLASK_BAL,
                                        'MO2_MEDIUM_PICKUP' => $row4 -> MO2_MEDIUM,
                                        'MO2_MEDIUM_BALANCE' => $MO2_MEDIUM_BAL,
                                        'MO2_STANDARD_PICKUP' => $row4 -> MO2_STANDARD,
                                        'MO2_STANDARD_BALANCE' => $MO2_STANDARD_BAL,
                                        'N2_FLASK_PICKUP' => $row4 -> N2_FLASK,
                                        'N2_FLASK_BALANCE' => $N2_FLASK_BAL,
                                        'N2_STANDARD_PICKUP' => $row4 -> N2_STANDARD,
                                        'N2_STANDARD_BALANCE' => $N2_STANDARD_BAL,
                                        'N2O_FLASK_PICKUP' => $row4 -> N2O_FLASK,
                                        'N2O_FLASK_BALANCE' => $N2O_FLASK_BAL,
                                        'N2O_STANDARD_PICKUP' => $row4 -> N2O_STANDARD,
                                        'N2O_STANDARD_BALANCE' => $N2O_STANDARD_BAL,
                                        'H_STANDARD_PICKUP' => $row4 -> H_STANDARD,
                                        'H_STANDARD_BALANCE' => $H_STANDARD_BAL,
                                        'COMPMED_STANDARD_PICKUP' => $row4 -> COMPMED_STANDARD,
                                        'COMPMED_STANDARD_BALANCE' => $COMPMED_STANDARD_BAL
                                    ]);

                                    db::table('summary_cylinder_balance_report')
                                        ->insert($query_3_data);
                                } // End Foreach of Row4
                            }
                        } // End Foreach of Row1112
                    }
                } // End Foreach of Query 2
            }
        }// End Foreach of Query1

        $summary_cylinder_report = db::table('summary_cylinder_balance_report')
            ->get();

//        dd($summary_cylinder_report);

        return view('Reports.CustomerReports.Reporting.statementcylinder')
            ->with('reportdata',$summary_cylinder_report);

    }


}
