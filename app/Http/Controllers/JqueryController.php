<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JqueryController extends Controller
{
    //
    public function prodCodeToSize(Request $request){

      $prodCode = $request -> prodcode;
      $html = '';

      $prodSize = DB::table('product_size')
                    ->where('PROD_CODE', $prodCode)
                    ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->SIZES == ''){

            }else {
                $html .= '<option value="' . $prodSize->SIZES . '">' . $prodSize->SIZES . '</option>';
            }
        }
      return response()->json([$html]);
    }

    public function getProductSize2(Request $request){
            $prodCode = $request -> prodcode;
            $html = '';

             $prodSize = DB::table('client')
                 ->join('product_list', 'client.CLIENTID', '=', 'product_list.CLIENTID')
                 ->where('PROD_CODE', $prodCode)
                 ->select('SIZE')
                 ->get();

            foreach ($prodSize as $prodSize) {
                if($prodSize->SIZE == ''){

                }else {
                    $data = $prodSize -> SIZE;
                }
            }

            return $data;
    }

    public function updateProductPrice(Request $request){

        $id = $request -> id;
        $price = $request -> price;

        $price = floatval(str_replace(",", "", $price));

        $updatePrice = DB::table('product_list')
                        ->where('id', $id)
                        ->update(['PRODUCT_PRICE' => $price]);

        if($updatePrice == 1){
		  return Response()->json(['updateStatus' => 'true']);
        }else{
		  return Response()->json(['updateStatus' => 'false']);
        }


    }

    public function getProductPO(Request $request){
        $clientCode = $request -> prodcode;
        $html = '';
        $html2 = '';

        $prodSize = DB::table('product_list')
            ->where('CLIENTID', $clientCode)
            ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->PROD_CODE == ''){

            }else {
                $html .= '<option value="' . $prodSize->PROD_CODE . '">' . $prodSize->PRODUCT . '</option>';
            }
        }
        return response()->json(array('html' => $html));
    }

    public function getProductSizePO(Request $request){
        $clientCode = $request -> prodcode;
        $id = $request -> id;



        $html = '';
        $html2 = '';

        $prodSize = DB::table('product_list')
            ->where('CLIENTID', $id)
            ->where('PROD_CODE', $clientCode)
            ->get();

        foreach ($prodSize as $prodSize) {
            if($prodSize->SIZE == ''){

            }else {
                $html .= '<option value="' . $prodSize->SIZE . '">' . $prodSize->SIZE . '</option>';
            }
        }
        return response()->json(array('html' => $html));
    }

}
