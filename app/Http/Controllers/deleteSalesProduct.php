<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class deleteSalesProduct extends Controller
{
    //
    public function deleteCLC (Request $request){

        $id = $request -> id;

        db::table('cylinder_loan_contract_list')
            ->where('ID', $id)
            ->delete();

        return response()->json(array('status' => 'success'));

    }

}
