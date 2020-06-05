<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        return view('SystemUtilities.Users.addusers');
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

        $user -> USERID = $userid;
        $user -> PASSWORD = $password;
        $user -> USERNAME = $username;
        $user -> DESIGNATION = $designation;
        $user -> USER_AUTHORIZATION = $auth;
        $user -> LASTNAME = $lname;
        $user -> FIRSTNAME = $fname;
        $user -> MIDDLENAME = $mname;
        $user -> EMAIL = $email;

        $user->save();

        auth()->login($user);

        return redirect()->to('SystemUtilities/SystemUsers');


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


        return view('SystemUtilities.Users.editusers')
            ->with('id', $id)
            ->with('users', $users);
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
