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
}
