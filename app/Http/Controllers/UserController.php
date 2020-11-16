<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Hash;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);
        return view('user.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'nid' => 'required|digits_between:10,14|unique:users',
            'phone' => 'required|digits:10|unique:users',
            'job' => 'required',
            'dob' => 'nullable|after:31-12-1940|before:31-12-2005',
        ]);

        $users = new User;
        $users->name = $request->input('name');
        $users->email = $request->input('email');
        $pass = $request->input('nid');
        $users->password = Hash::make($pass);
        $users->nid = $pass;
        $users->phone = $request->input('phone');
        $users->job_title = $request->input('job');
        $users->date_of_birth = $request->input('dob');
        $users->address = $request->input('address');
        $users->save();

        toastr()->success("Created Successfully!");
        return redirect('/admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit')->with('user',$user);
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
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'nid' => 'required|digits_between:10,14|unique:admins,nid,'.$id,
            'phone' => 'required|digits:10|unique:admins,phone,'.$id,
            'job' => 'required',
            'dob' => 'nullable|after:31-12-1940|before:31-12-2005',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->nid = $request->input('nid');
        $user->phone = $request->input('phone');
        $user->job_title = $request->input('job');
        $user->date_of_birth = $request->input('dob');
        $user->address = $request->input('address');
        $user->save();

        toastr()->success("Updated Successfully!");
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = User::find($id);
        $users->delete();

        toastr()->warning("Entry Deleted");
        return redirect('/admin/users');
    }

    public function destroyAll()
    {
        User::truncate();

        toastr()->error("All Records Deleted");
        return redirect('/admin/users');
    }
}
