<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class DeclarationController extends Controller
{
    //

    public function viewSalesDeclaration($id){
        $declaration = db::table('si_assigned')
            ->where('ID', $id)
            ->get();

        return view('SystemUtilities.SalesInvoiceDecleration.editsalesinvoice')
            ->with('declaration', $declaration);
    }

    public function updateSalesDeclaration(Request $request){

        $declaration_data = [
            'ENCODED_DATE' => $request->DateAssign,
            'FROM_OR_NO' => $request->FromInvoice,
            'TO_OR_NO' => $request->ToInvoice,
            'ASSIGNED_BY' => $request->assignedBy
        ];

        $declaraton = db::table('si_assigned')
            ->where('ID', $request -> id)
            ->update($declaration_data);

        $request->session()->flash('status', 'Sales Declaration Updated');
        return redirect()->route('SalesInvoiceController.create', $request->salesid);

    }

}
