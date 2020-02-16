<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CylinderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $clientProduct = db::table('client')
            ->join('product_list', 'product_list.CLIENTID' , '=' , 'client.CLIENTID')
            ->get();

        $readonly = "readonly=true";

        return view('cylinder.addcylinder')
            ->with('readonly', $readonly)
            ->with('clientProduct', $clientProduct);

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
        $client_id = $request -> clientid;
        $prodCode = $request -> productCode;
        $prodSize = $request -> prodSizes;
        $cutOff = $request -> cutoffDate;
        $qtyCylinder = $request -> qtyCylinder;

        $sameCylinder = db::table('cylinder_balance')
            ->where([
               ['client_code' , '=' , $client_id],
               ['product_code', '=' , $prodCode],
               ['product_size', '=', $prodSize],
               ['cylinder_cutoffdate', '=' , $cutOff]
            ]);

        if($sameCylinder->count() > 0){

            $data = $sameCylinder->get();

            foreach ($data as $row){

            }

            $cylinderQty = db::table('cylinder_balance')
                ->where([
                   ['client_code' , '=' , $client_id],
                   ['product_code', '=' , $prodCode],
                   ['product_size', '=', $prodSize],
                   ['cylinder_cutoffdate', '=' , $cutOff]
                ])
                ->update([
                    'cylinder_qty' => $qtyCylinder + $row -> cylinder_qty
                ]);

        }else{
        $cylinderQty = db::table('cylinder_balance')
            ->insert([
                'client_code' => $client_id,
                'product_code' => $prodCode,
                'product_size' => $prodSize,
                'cylinder_qty' => $qtyCylinder,
                'cylinder_cutoffdate' => $cutOff
            ]);
        }


       return redirect()->route('CylinderController.create', ['id' => $client_id]);


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
