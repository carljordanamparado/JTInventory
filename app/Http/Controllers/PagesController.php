<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function getDashboard(){
        return view('Dashboard');
    }

    public function getCustomerView(){

		$client = DB::table('client')
				->join('client_type', 'client.TYPE', '=', 'client_type.ID')
				->select('client.*', 'client_type.CLIENT_TYPE')
				->get();

    	return view('customer.viewcustomer' , ['client' => $client]);
    }

    public function getPriceCustomerView(){
        $client = DB::table('client')
            ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
            ->select('client.*', 'client_type.CLIENT_TYPE')
            ->get();

        return view('pricelist.viewpricelist' , ['client' => $client]);
    }

    public function getCylinderBalance(){
        $client = DB::table('client')
            ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
            ->select('client.*', 'client_type.CLIENT_TYPE')
            ->get();

        return view('cylinder.viewcylinder', ['client' => $client]);
    }

    public function getPurchaseOrder(){
        $client = DB::table('client')
            ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
            ->select('client.*', 'client_type.CLIENT_TYPE')
            ->get();

        return view('purchase_order.viewpurchase', ['client' => $client]);
    }

}
