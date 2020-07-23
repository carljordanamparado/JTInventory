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

    public function viewicrDeclaration($id){
        $declaration = db::table('icr_assigned')
            ->where('ID', $id)
            ->get();

        return view('SystemUtilities.ICRDeclaration.editicr')
            ->with('declaration', $declaration);
    }

    public function updateICRDeclaration(Request $request){

        $declaration_data = [
            'ENCODED_DATE' => $request->DateAssign,
            'FROM_NO' => $request->FromInvoice,
            'TO_NO' => $request->ToInvoice,
            'ASSIGNED_BY' => $request->assignedBy
        ];

        $declaraton = db::table('icr_assigned')
            ->where('ID', $request -> id)
            ->update($declaration_data);

        $request->session()->flash('status', 'ICR Declaration Updated');
        return redirect()->route('ICRController.create', $request->salesid);

    }

    public function viewclcDeclaration($id){
        $declaration = db::table('clc_assigned')
            ->where('ID', $id)
            ->get();

        return view('SystemUtilities.CLCDeclaration.editclc')
            ->with('declaration', $declaration);
    }

    public function updateCLCDeclaration(Request $request){

        $declaration_data = [
            'ENCODED_DATE' => $request->DateAssign,
            'FROM_NO' => $request->FromInvoice,
            'TO_NO' => $request->ToInvoice,
            'ASSIGNED_BY' => $request->assignedBy
        ];

        $declaraton = db::table('clc_assigned')
            ->where('ID', $request -> id)
            ->update($declaration_data);

        $request->session()->flash('status', 'CLC Declaration Updated');
        return redirect()->route('CLCController.create', $request->salesid);

    }

    public function viewdrDeclaration($id){
        $declaration = db::table('dr_assigned')
            ->where('ID', $id)
            ->get();

        return view('SystemUtilities.DRDeclaration.editdr')
            ->with('declaration', $declaration);
    }

    public function updateDRDeclaration(Request $request){

        $declaration_data = [
            'ENCODED_DATE' => $request->DateAssign,
            'FROM_NO' => $request->FromInvoice,
            'TO_NO' => $request->ToInvoice,
            'ASSIGNED_BY' => $request->assignedBy
        ];

        $declaraton = db::table('dr_assigned')
            ->where('ID', $request -> id)
            ->update($declaration_data);

        $request->session()->flash('status', 'DR Declaration Updated');
        return redirect()->route('DRController.create', $request->salesid);

    }

    public function vieworDeclaration($id){
        $declaration = db::table('dr_assigned')
            ->where('ID', $id)
            ->get();

        return view('SystemUtilities.ORDeclaration.editor')
            ->with('declaration', $declaration);
    }

    public function updateORDeclaration(Request $request){

        $declaration_data = [
            'ENCODED_DATE' => $request->DateAssign,
            'FROM_OR_NO' => $request->FromInvoice,
            'TO_OR_NO' => $request->ToInvoice,
            'ASSIGNED_BY' => $request->assignedBy
        ];

        $declaraton = db::table('or_assigned')
            ->where('ID', $request -> id)
            ->update($declaration_data);

        $request->session()->flash('status', 'OR Declaration Updated');
        return redirect()->route('ORController.create', $request->salesid);

    }

}
