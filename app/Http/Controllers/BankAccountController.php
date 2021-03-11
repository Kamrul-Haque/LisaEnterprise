<?php

namespace App\Http\Controllers;

use App\BankAccount;
use DB;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAccounts = BankAccount::latest()->paginate(10);
        return view('bank-accounts.index', compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bank-accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'bank'=>'required|string|min:4',
           'branch'=>'required|string|min:4',
           'account_no'=>'required|integer|min:5|unique:bank_accounts',
           'balance'=>'nullable|numeric',
        ]);

        $bankAccount = new BankAccount;
        $bankAccount->bank_name = $request->bank;
        $bankAccount->branch = $request->branch;
        $bankAccount->account_no = $request->account_no;
        $bankAccount->balance = $request->balance ?? 0;
        $bankAccount->save();

        toastr()->success('Created Successfully');
        return redirect('/bank-account');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        $bankAccount = BankAccount::find($bankAccount->id);
        return view('bank-accounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        $bankAccount = BankAccount::find($bankAccount->id);
        return view('bank-accounts.edit', compact('bankAccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank'=>'required|string|min:4',
            'branch'=>'required|string|min:4',
            'account_no'=>'required|integer|min:5|unique:bank_accounts,account_no,'.$bankAccount->id,
            'balance'=>'nullable|numeric',
        ]);

        $bankAccount = BankAccount::find($bankAccount->id);
        $bankAccount->bank_name = $request->bank;
        $bankAccount->branch = $request->branch;
        $bankAccount->account_no = $request->account_no;
        $bankAccount->balance = $request->balance;
        $bankAccount->save();

        toastr()->info('Updated Successfully');
        return redirect('/bank-account');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount = BankAccount::find($bankAccount->id);
        $bankAccount->delete();

        toastr()->warning('Record Deleted');
        return redirect('/bank-account');
    }

    public function destroyAll()
    {
        DB::table('bank_accounts')->delete();

        toastr()->error('All Records Deleted');
        return redirect('/bank-account');
    }
}
