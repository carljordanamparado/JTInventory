<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;

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

        $purchaseList = db::table('client')
            ->join('client_po' , 'client.CLIENTID' , '=' , 'client_po.CLIENTID')
            ->get();

        return view('purchase_order.viewpurchase', ['purchaselist' => $purchaseList]);
    }

    public function getSystemUsers(){

        $systemUsers = db::Table('users')->get();
       
        return view('SystemUtilities.Users.viewusers')
            ->with('systemUsers', $systemUsers);
    }

    public function getLogin(){
        return view('login');
    }

    public function postLogin(Request $request){

        $userdata = array(
            'USERID' => $request -> username ,
            'PASSWORD' => $request -> password
        );

        dd(Auth::attempt($userdata));
    }

    

}
