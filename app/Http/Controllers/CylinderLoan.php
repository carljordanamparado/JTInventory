<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CylinderLoan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $cylinder_data = db::table('cylinder_loan_contract')
            ->join('client', 'cylinder_loan_contract.CLIENT_NO', '=' , 'client.CLIENTID')
            ->get();

        return view('SalesRecord.CylinderLoan.viewcylinderloan')
            ->with('cylinder_data' , $cylinder_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = db::table('client')
            ->get();

        return view('SalesRecord.CylinderLoan.addcylinderloan')
            ->with('data', $data);
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

//        dd($request -> all());

        $cylinder_loan_data = array([
            'CLC_NO' => $request-> clcNo,
            'CLC_DATE' => $request -> cylinderDate,
            'CLIENT_NO' => $request -> customer,
            'RELEASEDBY' => $request -> releasedBy,
            'RECEIVED_DATE' => $request -> releasedDate,
            'RECEIVEDBY' => $request -> receivedBy,
            'INVOICE' => $request -> invoiceNo
        ]);

        $cylinder_loan_insert = db::table('cylinder_loan_contract')
            ->insert($cylinder_loan_data);

        $cylinder_loan_product = array();

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

        $sales_invoice_report = array([
            'CLC_NO' => $request -> clcNo,
            'CLIENT_NAME' => $request -> customer,
            'CLC_DATE' => $request -> cylinderDate,
            'C2H2' => $qty['C2H2'],
            'AR' => $qty['AR'],
            'CO2' => $qty['CO2'],
            'IO2' => $qty['IO2'],
            'LPG' => $qty['LPG'],
            'MO2' => $qty['MO2'],
            'N2' => $qty['N2'],
            'N2O' => $qty['N2O'],
            'H' => $qty['H'],
            'COMPMED' => $qty['COMPMED']
        ]);

        $sales_invoice_report_insert = db::table('cylinder_loan_contract_report2')
            ->insert($sales_invoice_report);



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
