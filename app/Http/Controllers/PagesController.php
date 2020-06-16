<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator,Redirect,Response;
Use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class PagesController extends Controller
{

    public function getDashboard(){

        if(session()->has('user')){
            return view('Dashboard');
        }else{
            return view('login');
        }
    }

    public function getCustomerView(){

		$client = DB::table('client')
				->join('client_type', 'client.TYPE', '=', 'client_type.ID')
				->select('client.*', 'client_type.CLIENT_TYPE')
                ->where('STATUS', '1')
                ->orderByDesc('CLIENTID')
                ->Paginate(50);

    	return view('customer.viewcustomer' , ['client' => $client]);

    }

    public function getPriceCustomerView(){
        $client = DB::table('client')
            ->join('client_type', 'client.TYPE', '=', 'client_type.ID')
            ->select('client.*', 'client_type.CLIENT_TYPE')
            ->where('STATUS', '1')
            ->orderByDesc('CLIENTID')
            ->Paginate(50);

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
            ->where('client_po.STATUS', '!=' , null)
            ->where('client_po.CLIENTID', '!=' , null)
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


        $credentials = $request->only('username', 'password');


        if(Auth::attempt(['userid' => $request -> userid, 'password' => $request->password])){

            session()->push('user', auth::user());
            return redirect() -> route('Dashboard');

        }else{

            return view('/');

        }


    }

    public function AccountLogout(){

        session()->flush();
        Return view('login');
    }

    

}
