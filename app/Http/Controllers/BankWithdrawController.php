<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankWithdraw;
use Auth;
use Illuminate\Http\Request;

class BankWithdrawController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bankAccounts = BankAccount::all();
        return view('bank-accounts.withdraw',compact('bankAccounts'));
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
            'account'=>'required',
            'type'=>'required',
            'cheque_no'=>'nullable|required_if:type,Cheque',
            'card'=>'nullable|required_if:type,Card',
            'validity'=>'nullable|required_if:type,Card',
            'cvv'=>'nullable|required_if:type,Card',
            'amount'=>'required|numeric|gt:0',
            'date'=>'required|before_or_equal:today',
        ]);

        $bankWithdraw = new BankWithdraw;
        $bankWithdraw->bank_account_id = $request->account;
        $bankWithdraw->type = $request->type;

        if ($request->type == 'Cheque')
        {
            $bankWithdraw->cheque_no = $request->cheque_no;
            $bankWithdraw->status = 'Pending';
        }
        else if ($request->type == 'Card')
        {
            $bankWithdraw->card_no = $request->card;
            $bankWithdraw->validity = $request->validity;
            $bankWithdraw->cvv = $request->cvv;
            $bankWithdraw->bankAccount->balance -= $request->amount;
        }
        else
            $bankWithdraw->bankAccount->balance -= $request->amount;

        $bankWithdraw->amount = $request->amount;
        $bankWithdraw->date_of_issue = $request->date;
        $bankWithdraw->entry_by = Auth::user()->name;
        $bankWithdraw->push();

        toastr()->success('Created Successfully');
        return redirect()->route('bank-account.show', $bankWithdraw->bankAccount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankWithdraw  $bankWithdraw
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankWithdraw $bankWithdraw)
    {
        $bankWithdraw = BankWithdraw::find($bankWithdraw->id);
        $bankWithdraw->bankAccount->balance += $bankWithdraw->amount;
        $bankWithdraw->push();
        $bankWithdraw->delete();

        toastr()->warning('Record Deleted');
        return redirect()->route('bank-account.show', $bankWithdraw->bankAccount);
    }

    public function restore($bankWithdraw)
    {
        BankWithdraw::onlyTrashed()->find($bankWithdraw)->restore();

        $bankWithdraw = BankWithdraw::find($bankWithdraw);
        $bankWithdraw->bankAccount->balance -= $bankWithdraw->amount;
        $bankWithdraw->push();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($bankWithdraw)
    {
        BankWithdraw::onlyTrashed()->find($bankWithdraw)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }

    public function editStatus(BankWithdraw $bankWithdraw)
    {
        return view('bank-accounts.change-withdraw-status', compact('bankWithdraw'));
    }

    public function updateStatus(Request $request, BankWithdraw $bankWithdraw)
    {
        $request->validate([
            'status'=>'required',
            'date'=>'nullable|required_if:status,Drawn|before_or_equal:today|after_or_equal:'.$bankWithdraw->getOriginal('date_of_issue'),
        ]);

        $bankWithdraw->status = $request->status;
        if ($request->status == 'Drawn')
        {
            $bankWithdraw->date_of_draw = $request->date;
            $bankWithdraw->bankAccount->balance -= $bankWithdraw->amount;
        }
        $bankWithdraw->push();

        toastr()->info('Status Updated');
        return redirect()->route('bank-account.show', $bankWithdraw->bankAccount);
    }
}
