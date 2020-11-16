<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Hash;
use App\Admin;
use Auth;


class AdminAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::orderBy('name')->paginate(10);
        return view('admin.index')->with('admins', $admins);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'nid' => 'required|digits_between:10,14|unique:admins',
            'phone' => 'required|digits:10|unique:admins',
            'job' => 'required',
            'dob' => 'nullable|after:31-12-1940|before:31-12-2005',
        ]);

        $admins = new Admin;
        $admins->name = $request->input('name');
        $admins->email = $request->input('email');
        $pass = $request->input('nid');
        $admins->password = Hash::make($pass);
        $admins->nid = $pass;
        $admins->phone = $request->input('phone');
        $admins->job_title = $request->input('job');
        $admins->date_of_birth = $request->input('dob');
        $admins->address = $request->input('address');
        $admins->save();

        toastr()->success("Created Successfully!");
        return redirect('/admin/accounts');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        return view('admin.edit')->with('admin',$admin);
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
            'dob' => 'nullable||after:31-12-1940|before:31-12-2005',
        ]);

        $admin = Admin::find($id);
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->nid = $request->input('nid');
        $admin->phone = $request->input('phone');
        $admin->job_title = $request->input('job');
        $admin->date_of_birth = $request->input('dob');
        $admin->address = $request->input('address');
        $admin->save();

        toastr()->success("Updated Successfully!");
        return redirect('/admin/accounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $admins = Admin::find($id);
        $admins->delete();

        toastr()->warning("Entry Deleted");
        return redirect('/admin/accounts');
    }

    public function destroyAll()
    {
        Admin::truncate();

        toastr()->error("All records Deleted");
        return redirect('/admin/accounts');
    }

    public function passwordChangeForm()
    {
        return view('auth.passwords.change-password');
    }

    public function passwordChange(Request $request)
    {
        $id = $request->input('id');

        $admin = Admin::find($id);
        if (Hash::check($request->input('old'),$admin->password))
        {
            if ($request->input('password') == $request->input('password_confirmation'))
            {
                $admin->password = Hash::make($request->input('password'));
                $admin->save();

                Auth::logout();
                toastr()->success('Password Changed Successfully');
                return redirect('/admin/login');
            }
            else
            {
                toastr()->warning('New Passwords don\'t Match');
                return back();
            }
        }
        else
        {
            toastr()->error('Old Passwords don\'t Match');
            return back();
        }
    }
}
