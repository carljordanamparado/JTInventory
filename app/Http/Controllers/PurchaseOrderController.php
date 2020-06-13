<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
        $client = DB::table('client')
            ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
            ->select('client.*', 'client_type.CLIENT_TYPE')
            ->get();
        return view('purchase_order.addpurchaseorder')
            ->with('client', $client);

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

        if($request -> status == 1){
             $purchase = db::table('client_po')
                ->insert([
                    'CLIENTID' => $request -> custCode,
                    'PO_NO' => $request -> poNo,
                    'PO_DATE' => $request -> poDate,
                    'STATUS' => "1"
                ]);


            for($i = 0 ; $i < count($request -> productCode) ; $i++){

                $productPurchase = db::table('client_po_list')
                    ->insert([
                        'CLIENTPO_ID' => $request -> custCode,
                        'PO_NO' => $request -> poNo,
                        'PO_DATE' => $request -> poDate,
                        'PRODUCT' => $request -> productCode[$i],
                        'SIZE' => $request -> productSize[$i],
                        'QUANTITY' => $request -> productQty[$i],
                        'TOTAL_QUANTITY' => $request -> productQty[$i]
                    ]);

            }

        }elseif($request -> status == 2){

                for($i = 0 ; $i < count($request -> productCode) ; $i++){

                $productPurchase = db::table('client_po_list')
                    ->insert([
                        'CLIENTPO_ID' => $request -> custCode,
                        'PO_NO' => $request -> poNo,
                        'PO_DATE' => $request -> poDate,
                        'PRODUCT' => $request -> productCode[$i],
                        'SIZE' => $request -> productSize[$i],
                        'QUANTITY' => $request -> productQty[$i],
                        'TOTAL_QUANTITY' => $request -> productQty[$i]
                    ]);

            }
        }

       return redirect('Purchase_Order');
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

        $purchaseOrder = DB::table('client_po')
            ->where('PO_NO', $id)
            ->get();


        $purchaseOrderList = DB::table('client_po_list')
            ->join('products', 'client_po_list.PRODUCT' ,'=', 'products.PROD_CODE')
            ->where('PO_NO', $id)
            ->get();

        return view('purchase_order.editpurchaseorder')
            ->with('id', $id)
            ->with('purchaseOrder', $purchaseOrder)
            ->with('purchaseOrderList', $purchaseOrderList);

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
