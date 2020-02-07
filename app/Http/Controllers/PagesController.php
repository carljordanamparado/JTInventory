<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function getDashboard(){
        return view('Dashboard');
    }

    public function getCustomerView(){
    	return view('customer.viewcustomer');
    }
}
