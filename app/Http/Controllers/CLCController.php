<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CLCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
         $salesRep = db::table('sales_rep')
            ->get();

        return view('SystemUtilities.CLCDeclaration.viewclc')
            ->with('salesRep', $salesRep);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $clc = db::table('clc_assigned')
            ->where('SALESREP_ID', $id)
            ->get();

        //
        return view('SystemUtilities.CLCDeclaration.addclc')
            ->with('clc', $clc)
            ->with('id', $id);
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
        $salesInvoice = db::table('clc_assigned')
            ->insert([
                'SALESREP_ID' => $request -> id,
                'FROM_NO' => $request ->  FromInvoice,
                'TO_NO' => $request -> ToInvoice,
                'ENCODED_DATE' => $request -> DateAssign,
                'ASSIGNED_BY' => $request -> assignedBy
            ]);

        return redirect()->route('CLCController.create', $request -> id);

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
