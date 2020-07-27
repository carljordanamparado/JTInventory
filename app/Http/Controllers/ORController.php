<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ORController extends Controller
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
            $salesRep = db::table('sales_rep')
                ->get();

            return view('SystemUtilities.ORDeclaration.viewor')
                ->with('salesRep', $salesRep);
       }else{
           return view('login');
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $dr = db::table('or_assigned')
            ->where('SALESREP_ID', $id)
            ->get();

        //
        return view('SystemUtilities.ORDeclaration.addor')
            ->with('dr', $dr)
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
        $salesInvoice = db::table('or_assigned')
            ->insert([
                'SALESREP_ID' => $request -> id,
                'FROM_OR_NO' => $request ->  FromInvoice,
                'TO_OR_NO' => $request -> ToInvoice,
                'ENCODED_DATE' => $request -> DateAssign,
                'ASSIGNED_BY' => $request -> assignedBy
            ]);

        return redirect()->route('ORController.create', $request -> id);

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
