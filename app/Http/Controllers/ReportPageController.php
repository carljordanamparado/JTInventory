<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
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
            ->select('sales_invoice.INVOICE_NO AS REPORTNO','sales_invoice.INVOICE_DATE AS REPORTDATE',DB::raw('sales_invoice.TOTAL - sales_invoice.DOWNPAYMENT as TOTAL'),'sales_invoice_po.PO_NO AS PONO')
            ->selectRaw('"INVOICE" as type')
            ->leftJoin('sales_invoice_po', 'sales_invoice.INVOICE_NO', '=', 'sales_invoice_po.INVOICE_NO')
            ->where('sales_invoice.STATUS', 1)
            ->where('sales_invoice.CLIENT_ID', $id)
            ->where('sales_invoice.FULLY_PAID', 0)
            ->whereBetween('sales_invoice.INVOICE_DATE', [$from_date , $to_date]);

        $data2 = db::table('delivery_receipt as c')
            ->select('c.DR_NO AS REPORTNO','c.DR_DATE AS REPORTDATE', DB::raw('c.TOTAL - c.DOWNPAYMENT as TOTAL'),'d.PO_NO')
            ->selectRaw('"DR" as REPORTTYPE')
            ->leftJoin('delivery_receipt_po as d', 'c.DR_NO', '=' , 'd.DR_NO')
            ->where('c.STATUS', 1)
            ->where('c.CLIENT_ID', $id)
            ->where('c.FULLY_PAID', 0)
            ->whereBetween('c.DR_DATE', [$from_date , $to_date])
            ->orderByRaw(2)
            ->unionAll($data)
            ->get();


      /*  return view('Reports.CustomerReports.Reporting.statement')
            ->with('data2', $data);*/



        $pdf = App::make('dompdf.wrapper');
        $pdf = PDF::loadView('Reports.CustomerReports.Reporting.statement', ['data2' => $data2]);
        return $pdf->stream();


    }

    public function viewSummaryReport(){

    }

}
