<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankDeposit;
use App\BankWithdraw;
use App\CashRegister;
use Auth;
use Illuminate\Http\Request;

class CashRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashs = CashRegister::latest()->paginate(10);
        return view('cash-register.index', compact('cashs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CashRegister $cashRegister)
    {
        return view('cash-register.show', compact('cashRegister'));
    }

    public function depositForm()
    {
        return view('cash-register.deposit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deposit(Request $request)
    {
        $this->validate($request, [
           'amount' => 'required|numeric',
           'title' => 'required',
           'date' => 'required|after:31-12-2004|before_or_equal:today',
        ]);

        $cash = new CashRegister;
        $cash->type = "Deposit";
        $cash->amount = $request->input('amount');
        $cash->title = $request->input('title');
        $cash->description = $request->input('description');
        $cash->date = $request->input('date');
        $cash->save();

        toastr()->success('Deposited Successfully!');
        return redirect('/cash-register');
    }

    public function withdrawForm()
    {
        return view('cash-register.withdraw');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function withdraw(Request $request)
    {
        $this->validate($request, [
           'amount' => 'required|numeric',
           'title' => 'required',
           'date' => 'required|after:31-12-2004|before_or_equal:today',
        ]);

        $cash = new CashRegister;
        $cash->type = "Withdraw";
        $cash->amount = $request->input('amount');
        $cash->title = $request->input('title');
        $cash->description = $request->input('description');
        $cash->date = $request->input('date');
        $cash->save();

        toastr()->success('Deposited Successfully!');
        return redirect('/cash-register');
    }

    public function destroy(CashRegister $cashRegister)
    {
        if ($cashRegister->bank_account_id)
        {
            if ($cashRegister->type == "Withdraw")
            {
                $cashRegister->bankAccount->balance -= $cashRegister->amount;
            }
            else
                $cashRegister->bankAccount->balance += $cashRegister->amount;
        }

        $cashRegister->push();
        $cashRegister->delete();

        toastr()->warning('Entry Deleted');
        return redirect('/cash-register');
    }

    public function destroyAll()
    {
        CashRegister::truncate();

        toastr()->error('All Records deleted');
        return redirect('/cash-register');
    }

    public function restore($cashRegister)
    {
        CashRegister::onlyTrashed()->find($cashRegister)->restore();

        $cashRegister = CashRegister::find($cashRegister);
        if ($cashRegister->bank_account_id)
        {
            if ($cashRegister->type == "Withdraw")
            {
                $cashRegister->bankAccount->balance += $cashRegister->amount;
            }
            else
                $cashRegister->bankAccount->balance -= $cashRegister->amount;
        }
        $cashRegister->push();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($client)
    {
        CashRegister::onlyTrashed()->find($client)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }

    public function withdrawToBankForm()
    {
        $bankAccounts = BankAccount::all();
        return view('cash-register.withdraw-to-bank', compact('bankAccounts'));
    }

    public function withdrawToBank(Request $request)
    {
        $request->validate([
            'account'=>'required',
            'amount'=>'required|numeric|gt:0|lte:'.CashRegister::balance(),
            'date'=>'required|before_or_equal:today',
        ]);

        $cash = new CashRegister;
        $cash->type = "Withdraw";
        $cash->amount = $request->amount;
        $cash->title = "Withdrawn to Bank";
        $cash->date = $request->date;
        $cash->bank_account_id = $request->account;
        $cash->save();

        $bankDeposit = new BankDeposit;
        $bankDeposit->bank_account_id = $request->account;
        $bankDeposit->type = "Cash";
        $bankDeposit->bankAccount->balance += $request->amount;
        $bankDeposit->amount = $request->amount;
        $bankDeposit->date_of_issue = $request->date;
        $bankDeposit->entry_by = Auth::user()->name;
        $bankDeposit->push();

        toastr()->success('Withdrawn Successfully');
        return redirect('/cash-register');
    }

    public function depositFromBankForm()
    {
        $bankAccounts = BankAccount::all();
        return view('cash-register.deposit-from-bank', compact('bankAccounts'));
    }

    public function depositFromBank(Request $request)
    {
        $account = BankAccount::find($request->account);
        $balance = $account->balance;

        $request->validate([
            'account'=>'required',
            'amount'=>'required|numeric|gt:0|lte:'.$balance,
            'date'=>'required|before_or_equal:today',
        ]);

        $cash = new CashRegister;
        $cash->type = "Deposit";
        $cash->amount = $request->amount;
        $cash->title = "Deposited from Bank";
        $cash->date = $request->date;
        $cash->bank_account_id = $request->account;
        $cash->save();

        $bankWithdraw = new BankWithdraw;
        $bankWithdraw->bank_account_id = $request->account;
        $bankWithdraw->type = "Cash";
        $bankWithdraw->bankAccount->balance -= $request->amount;
        $bankWithdraw->amount = $request->amount;
        $bankWithdraw->date_of_issue = $request->date;
        $bankWithdraw->entry_by = Auth::user()->name;
        $bankWithdraw->push();

        toastr()->success('Deposited Successfully');
        return redirect('/cash-register');
    }
}
