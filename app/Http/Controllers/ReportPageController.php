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

        if($from_date == '' && $to_date == ''){
            $sales_invoice = db::table('sales_invoice as a')
                ->select('a.INVOICE_NO', 'a.INVOICE_DATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO','c.PRODUCT', 'c.SIZE', 'c.QTY')
                ->join('sales_invoice_po as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
                ->join('sales_invoice_order as c', 'a.INVOICE_NO', '=', 'c.INVOICE_NO')
                ->where('a.CLIENT_ID', $id)
                ->get();

            $delivery = db::table('delivery_receipt as a')
                ->select('a.DR_NO', 'a.DR_DATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO','c.PRODUCT', 'c.SIZE', 'c.QTY')
                ->join('delivery_receipt_po as b', 'a.DR_NO', '=', 'b.DR_NO')
                ->join('delivery_receipt_order as c', 'a.DR_NO', '=', 'c.DR_NO')
                ->where('a.CLIENT_ID', $id)
                ->get();
        }else{
            $sales_invoice = db::table('sales_invoice as a')
                ->select('a.INVOICE_NO', 'a.INVOICE_DATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO','c.PRODUCT', 'c.SIZE', 'c.QTY')
                ->join('sales_invoice_po as b', 'a.INVOICE_NO', '=', 'b.INVOICE_NO')
                ->join('sales_invoice_order as c', 'a.INVOICE_NO', '=', 'c.INVOICE_NO')
                ->where('a.CLIENT_ID', $id)
                ->whereBetween('a.INVOICE_DATE', [$from_date,$to_date])
                ->get();

            $delivery = db::table('delivery_receipt as a')
                ->select('a.DR_NO', 'a.DR_DATE', db::raw('(TOTAL - DOWNPAYMENT) as TOTAL'),'b.PO_NO','c.PRODUCT', 'c.SIZE', 'c.QTY')
                ->join('delivery_receipt_po as b', 'a.DR_NO', '=', 'b.DR_NO')
                ->join('delivery_receipt_order as c', 'a.DR_NO', '=', 'c.DR_NO')
                ->where('a.CLIENT_ID', $id)
                ->whereBetween('a.DR_DATE', [$from_date,$to_date])
                ->get();
        }


        $arr = array();
        $arr2 = array();

        for($i = 0; $i < count($sales_invoice) ; $i++){

            $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
            $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

            if($sales_invoice[$i] ->PRODUCT == "C2H2"){
                $C2H2 += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "AR"){
                $AR += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "CO2"){
                $CO2 += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "IO2"){
                $IO2 += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] -> PRODUCT == "LPG"){
                $LPG += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "MO2"){
                if($sales_invoice[$i] -> SIZE == "FLASK"){
                    $MO2F += (int)$sales_invoice[$i] -> QTY ;
                }elseif($sales_invoice[$i] -> SIZE == "STANDARD"){
                    $MO2S += (int)$sales_invoice[$i] -> QTY ;
                }
            }
            if($sales_invoice[$i] ->PRODUCT == "N2"){
                $N2 += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "N20"){
                $N20 += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "H"){
                $H += (int)$sales_invoice[$i] -> QTY ;
            }
            if($sales_invoice[$i] ->PRODUCT == "COMPMED"){
                $COMPMED += (int)$sales_invoice[$i] -> QTY ;
            }

            $totalOther2 = 0;

            $sales_other = db::table('other_charges')
                ->select('QUANTITY', 'UNIT_PRICE')
                ->where('INVOICE_NO', $sales_invoice[$i] -> INVOICE_NO)
                ->get();

            foreach($sales_other as $other_price){
                $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
            }

            $sales_invoice_report[$i] = array([
                'INVOICE_NO' => $sales_invoice[$i] -> INVOICE_NO,
                'INVOICE_DATE' => $sales_invoice[$i] -> INVOICE_DATE,
                'PO_NO' => $sales_invoice[$i] -> PO_NO,
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
                'OTHER_CHARGES' => $totalOther2,
                'TOTAL' => $sales_invoice[$i] -> TOTAL
            ]);

            $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
            $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

        }

        for($i = 0; $i < count($delivery) ; $i++){

            $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
            $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;

            if($delivery[$i] ->PRODUCT == "C2H2"){
                $C2H2 += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "AR"){
                $AR += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "CO2"){
                $CO2 += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "IO2"){
                $IO2 += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] -> PRODUCT == "LPG"){
                $LPG += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "MO2"){
                if($delivery[$i] -> SIZE == "FLASK"){
                    $MO2F += (int)$delivery[$i] -> QTY ;
                }elseif($delivery[$i] -> SIZE == "STANDARD"){
                    $MO2S += (int)$delivery[$i] -> QTY ;
                }
            }
            if($delivery[$i] ->PRODUCT == "N2"){
                $N2 += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "N20"){
                $N20 += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "H"){
                $H += (int)$delivery[$i] -> QTY ;
            }
            if($delivery[$i] ->PRODUCT == "COMPMED"){
                $COMPMED += (int)$delivery[$i] -> QTY ;
            }

            $totalOther2 = 0;

            $dr_other = db::table('dr_other_charges')
                ->select('QUANTITY', 'UNIT_PRICE')
                ->where('DR_NO', $delivery[$i] -> DR_NO)
                ->get();

            foreach($dr_other as $other_price){
                $totalOther2 = $totalOther2 + ($other_price -> UNIT_PRICE * $other_price -> QUANTITY);
            }

            $delivery_report[$i] = array([
                'DR_NO' => $delivery[$i] -> DR_NO,
                'DR_DATE' => $delivery[$i] -> DR_DATE,
                'PO_NO' => $delivery[$i] -> PO_NO,
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
                'OTHER_CHARGES' => $totalOther2,
                'TOTAL' => $delivery[$i] -> TOTAL
            ]);

            $C2H2 = 0;$AR = 0;$CO2 = 0;$IO2 = 0;$LPG = 0;
            $MO2F = 0; $MO2S = 0;$N2 = 0;$N20 = 0;$H = 0;$COMPMED = 0;
        }

        if($delivery->isEmpty() && $sales_invoice->isNotEmpty()){
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('sales_data', $sales_invoice_report)
                ->with('dr_data', "empty");
        }if($sales_invoice->isEmpty() &&  $delivery ->isNotEmpty()){
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('dr_data',$delivery_report)
                 ->with('sales_data', "empty");
        }if($delivery->isEmpty() && $sales_invoice->isEmpty()){
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('dr_data',"empty")
                ->with('sales_data', "empty");
        }if($delivery->isNotEmpty() && $sales_invoice->isNotEmpty()){
            return view('Reports.CustomerReports.Reporting.statement')
                ->with('sales_data', $sales_invoice_report)
                ->with('dr_data',$delivery_report);
        }


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

    }


}
