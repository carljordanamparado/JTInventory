<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SalesRepController extends Controller
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
            $salesrep = db::table('sales_rep')
                ->get();
            return view('SystemUtilities.SalesRepresentative.viewsalesrep', ['salesrep' => $salesrep]);
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

        return view('SystemUtilities.SalesRepresentative.addsalesrep');

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
        $salesRep = DB::table('sales_rep')
                  ->insert([
                    'SALESREP_NAME' => $request -> input('nickname'),
                    'DESIGNATION' => $request -> input('Designation'),
                    'LASTNAME' => $request -> input('lname'),
                    'FIRSTNAME' => $request -> input('fname'),
                    'MIDDLENAME' => $request -> input('mname'),
                    'EMAIL' => $request -> input('emailAdd'),
                    'CONTACT_NO' => $request -> input('contNo'),
                    'BIRTH_DATE' => $request -> input('birthdate'),
                    'ADDRESS' => $request -> input('address')
                  ]);

        return redirect()->route('SalesRepController.index');

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

        $salesRep = db::table('sales_rep')
            ->where('ID', '=', $id)
            ->get();

        return view('SystemUtilities.SalesRepresentative.editsalesrep', ['salesRep' => $salesRep]);
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
        $salesRep = db::table('sales_rep')
            ->where('ID', $id)
            ->update([
                'SALESREP_NAME' => $request -> nickname,
                'DESIGNATION' => $request -> Designation,
                'LASTNAME' => $request -> lname,
                'FIRSTNAME' => $request -> fname,
                'MIDDLENAME' => $request -> mname,
                'EMAIL' => $request -> emailAdd,
                'ADDRESS' => $request -> address,
                'BIRTH_DATE' => $request -> birthdate,
                'CONTACT_NO' => $request -> contNo
            ]);

        return redirect()->route('SalesRepController.index');
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
