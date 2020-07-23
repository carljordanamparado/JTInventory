<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $clientType = DB::table('client_type')->get();

        return view('customer.addcustomer' , ['clientType' => $clientType]);



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $clientCode = DB::table('client')->max('CLIENT_CODE');
        $clientCode = $clientCode + 1;

        if(strlen($clientCode) == 1){
            $cCode = "000" . strval($clientCode);
        }elseif(strlen($clientCode) == 2){
            $cCode = "00" . strval($clientCode);
        }elseif(strlen($clientCode) == 3){
            $cCode = "0" . strval($clientCode);
        }else{
            $cCode = $clientCode;
        }

        $custName = $request->input("custName");
        $address = $request->input("Address");
        $city = $request->input("City");
        $custType = $request->input("custType");
        $custSince = $request->input("custSince");
        $tinNo = $request->input("tinNo");
        $contPerson = $request->input("contPerson");
        $Designation = $request->input("Designation");
        $telNo = $request->input("telNo");
        $contNo = $request->input("contNo");
        $emailAdd = $request->input("emailAddress");
        $cashPay = $request->input("cashPay");
        $orCopy = $request->input("orCopy");

        $client = DB::table("client")->insert([
	        [
		        'NAME' => $custName,
		        'TYPE' => $custType,
		        'DTI_NO' => $tinNo,
		        'ADDRESS' => $address,
		        'CITY_MUN' => $city,
		        'CON_PERSON' => $contPerson,
		        'DESIGNATION' => $Designation,
		        'TEL_NO' => $telNo,
		        'CELL_NO' => $contNo,
		        'EMAIL_ADDR' => $emailAdd,
		        'CLIENT_DATE' => $custSince,
		        'CLIENT_CODE' => $cCode,
		        'PAYMENT_TYPE' => $cashPay,
		        'ORCOPY' => $orCopy
	        ]
        ]);

        if($client == true){
//	        $request->session()->flash('status', 'True');
        	return redirect('Customer');
        }else{
//	        $request->session()->flash('status', 'False');
			return redirect('CustomerController/create');
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
	    $client = DB::table('client')
		        ->where("CLIENTID", "=" , $id)
		        ->get();
	    $clientType = DB::table('client_type')->get();



	    return view('customer.editcustomer')
		        ->with('client', $client)
	            ->with('clientType', $clientType);

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

        $custName = $request->input("custName");
        $address = $request->input("Address");
        $city = $request->input("City");
        $custType = $request->input("custType");
        $custSince = $request->input("custSince");
        $tinNo = $request->input("tinNo");
        $contPerson = $request->input("contPerson");
        $Designation = $request->input("Designation");
        $telNo = $request->input("telNo");
        $contNo = $request->input("contNo");
        $emailAdd = $request->input("emailAddress");
        $cashPay = $request->input("cashPay");
        $orCopy = $request->input("orCopy");

        $clientUpdate = DB::table('client')
                        ->where('CLIENTID' , $id)
                        ->update([
                            'NAME' => $custName,
                            'TYPE' => $custType,
                            'DTI_NO' => $tinNo,
                            'ADDRESS' => $address,
                            'CITY_MUN' => $city,
                            'CON_PERSON' => $contPerson,
                            'DESIGNATION' => $Designation,
                            'TEL_NO' => $telNo,
                            'CELL_NO' => $contNo,
                            'EMAIL_ADDR' => $emailAdd,
                            'CLIENT_DATE' => $custSince,
                            'PAYMENT_TYPE' => $cashPay,
                            'ORCOPY' => $orCopy
                        ]);

        if($clientUpdate == true){
//            $request->session()->flash('statusUpdate', 'True');
            return redirect('Customer');
        }else{
//            $request->session()->flash('status', 'False');
            return redirect('CustomerController/show', $id);
        }

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
