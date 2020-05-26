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
        return view('SalesRecord.CylinderLoan.viewcylinderloan');
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

        $cylinder_load_product = array();

        $cylinder_load_product = [
            'CLC_NO' => ,
            'CLC_DATE' => ,
            'CLIENT_NO' => ,
            'PRODUCT' => ,
            'SIZE' => ,
            'QUANTITY' =>
        ];


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
