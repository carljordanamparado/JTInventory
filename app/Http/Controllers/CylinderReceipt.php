<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class CylinderReceipt extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if(session()->has('user')){
            $cylinder_data = db::table('cylinder_receipt')
                ->join('client', 'cylinder_receipt.CLIENT_NO', '=' , 'client.CLIENTID')
                ->where('icr_tag', 0)
                ->get();

            return view('SalesRecord.CylinderReceipt.viewcylinderreceipt')
                ->with('cylinder_data' , $cylinder_data);
       }else{
           return view('login');
       }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $client_data = db::table('client')
            ->get();

        return view('SalesRecord.CylinderReceipt.addcylinderreceipt')
            ->with('data' , $client_data);
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

        $cylinder_receipt_data = array([
            'ICR_NO' => $request -> icrNo,
            'ICR_DATE' => $request -> cylinderDate,
            'CLIENT_NO' => $request -> customer,
            'REFILL' => $type1,
            'RETURNED' => $type2,
            'OTHERS' => $type3,
            'OTHERS_TEXT' => $otherDescription,
            'RELEASEDBY' => $request -> releasedBy,
            'RECEIVED_DATE' => $request -> releasedDate,
            'RECEIVEDBY' => $request -> receivedBy,
            'ICR_TAG' => 0,
            'STATUS' => 1
        ]);

        $cylinder_receipt_insert = db::table('cylinder_receipt')
            ->insert($cylinder_receipt_data);

        $cylinder_list_data = array();

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

        $qty = Arr::add($qty , 'C2H2', $C2H2);
        $qty = Arr::add($qty , 'CO2', $CO2);
        $qty = Arr::add($qty , 'AR', $AR);
        $qty = Arr::add($qty , 'COMPMED', $COMPMED);
        $qty = Arr::add($qty , 'H', $H);
        $qty = Arr::add($qty , 'IO2', $IO2);
        $qty = Arr::add($qty , 'LPG', $LPG);
        $qty = Arr::add($qty , 'N2', $N2);
        $qty = Arr::add($qty , 'MO2', $MO2);
        $qty = Arr::add($qty , 'N2O', $N20);

        $icr_report_data = array([
            'ICR_NO' => $request->icrNo,
            'CLIENT_NAME' => $request->customer,
            'ICR_DATE' => $request -> cylinderDate,
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

        $icr_report_insert = db::table('cylinder_receipt_report')
            ->insert($icr_report_data);

        $noController = array([
            'ICR_NO' => $request-> icrNo,
            'REMARKS' => 'DONE'
        ]);

        db::table('icr_assigned_report')
            ->insert($noController);

        return response()->json(array('status' => 'success'));

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
