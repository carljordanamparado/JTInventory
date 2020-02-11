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

}
