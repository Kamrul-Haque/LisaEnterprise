<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankDeposit;
use Auth;
use Illuminate\Http\Request;

class BankDepositController extends Controller
{
    public function create()
    {
        $bankAccounts = BankAccount::all();
        return view('bank-accounts.deposit',compact('bankAccounts'));
    }

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

        $bankDeposit = new BankDeposit;
        $bankDeposit->bank_account_id = $request->account;
        $bankDeposit->type = $request->type;

        if ($request->type == 'Cheque')
        {
            $bankDeposit->cheque_no = $request->cheque_no;
            $bankDeposit->status = 'Pending';
        }
        else if ($request->type == 'Card')
        {
            $bankDeposit->card_no = $request->card;
            $bankDeposit->validity = $request->validity;
            $bankDeposit->cvv = $request->cvv;
            $bankDeposit->bankAccount->balance += $request->amount;
        }
        else
            $bankDeposit->bankAccount->balance += $request->amount;

        $bankDeposit->amount = $request->amount;
        $bankDeposit->date_of_issue = $request->date;
        $bankDeposit->entry_by = Auth::user()->name;
        $bankDeposit->push();

        toastr()->success('Created Successfully');
        return redirect()->route('bank-account.show', $bankDeposit->bankAccount);
    }

    public function destroy(BankDeposit $bankDeposit)
    {
        $bankDeposit->bankAccount->balance -= $bankDeposit->amount;
        $bankDeposit->push();
        $bankDeposit->delete();

        toastr()->warning('Record Deleted');
        return redirect()->route('bank-account.show', $bankDeposit->bankAccount);
    }

    public function restore($bankDeposit)
    {
        BankDeposit::onlyTrashed()->find($bankDeposit)->restore();

        $bankDeposit = BankDeposit::find($bankDeposit);
        $bankDeposit->bankAccount->balance += $bankDeposit->amount;
        $bankDeposit->push();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($bankDeposit)
    {
        BankDeposit::onlyTrashed()->find($bankDeposit)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }

    public function editStatus(BankDeposit $bankDeposit)
    {
        return view('bank-accounts.change-deposit-status', compact('bankDeposit'));
    }

    public function updateStatus(Request $request, BankDeposit $bankDeposit)
    {
        $request->validate([
            'status'=>'required',
            'date'=>'nullable|required_if:status,Drawn|before_or_equal:today|after_or_equal:'.$bankDeposit->getOriginal('date_of_issue'),
        ]);

        $bankDeposit->status = $request->status;
        if ($request->status == 'Drawn')
        {
            $bankDeposit->date_of_draw = $request->date;
            $bankDeposit->bankAccount->balance += $bankDeposit->amount;
        }
        $bankDeposit->push();

        toastr()->info('Status Updated');
        return redirect()->route('bank-account.show', $bankDeposit->bankAccount);
    }
}
