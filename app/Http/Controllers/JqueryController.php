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
}
