<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SystemUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user_level = db::table('user_level')
            ->get();

        return view('SystemUtilities.Users.addusers')
            ->with('user_level', $user_level);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $user = new User;

        $userid = $request -> userid;
        $password = Hash::make($request -> password);
        $username = $request -> lname . "," . $request -> fname . " " . $request -> mname;
        $designation = $request -> designation;
        $auth = $request -> auth;
        $lname = $request -> lname;
        $fname = $request -> fname;
        $mname = $request -> mname;
        $email = $request -> email;

        $user -> userid = $userid;
        $user -> password = $password;
        $user -> username = $username;
        $user -> designation = $designation;
        $user -> user_authorization = $auth;
        $user -> lastname = $lname;
        $user -> firstname = $fname;
        $user -> middlename = $mname;
        $user -> email = $email;

        $user->save();

        if (Auth::attempt($request->only('userid', 'password'))) {
            return view('dashboard')
                ->with('Welcome! Your account has been successfully created!');
        }

        /*return redirect()->to('SystemUtilities/SystemUsers');*/


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

        $users = db::table('users')->where('ID', $id)->get();
        $user_level = db::table('user_level')
            ->get();


        return view('SystemUtilities.Users.editusers')
            ->with('id', $id)
            ->with('users', $users)
            ->with('user_level', $user_level);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $salesRep = db::table('users')
        ->where('ID', $id)
        ->update([
            'DESIGNATION' => $request -> designation,
            'LASTNAME' => $request -> lname,
            'FIRSTNAME' => $request -> fname,
            'MIDDLENAME' => $request -> mname,
            'EMAIL' => $request -> email,
            'USER_AUTHORIZATION' => $request -> auth,
        ]);

    return redirect()->route('SystemUsers');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
