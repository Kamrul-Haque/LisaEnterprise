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
        $cashs = CashRegister::latest()->paginate(11);
        return view('cash-register.index', compact('cashs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CashRegister $cashRegister)
    {
        $cashRegister = CashRegister::find($cashRegister->id);
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
        return redirect('/admin/cash-register');
    }

    public function withdrawForm()
    {
        return view('cash-register.withdraw');
    }

    public function balance()
    {
        $deposit = CashRegister::where('type', 'deposit')->sum('amount');
        $withdraw = CashRegister::where('type', 'withdraw')->sum('amount');
        $balance = $deposit - $withdraw;

        return response()->json($balance);
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
        return redirect('/admin/cash-register');
    }

    public function destroy(CashRegister $cashRegister)
    {
        $cash = CashRegister::find($cashRegister->id);
        $cash->delete();

        toastr()->warning('Entry Deleted');
        return redirect('/admin/cash-register');
    }

    public function destroyAll()
    {
        CashRegister::truncate();

        toastr()->error('All Records deleted');
        return redirect('/admin/cash-register');
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
            'type'=>'required',
            'cheque_no'=>'nullable|required_if:type,Cheque',
            'card'=>'nullable|required_if:type,Card',
            'validity'=>'nullable|required_if:type,Card',
            'cvv'=>'nullable|required_if:type,Card',
            'amount'=>'required|numeric|gt:0|lte:'.$this->balance(),
            'date'=>'required|before_or_equal:today',
        ]);

        $cash = new CashRegister;
        $cash->type = "Withdraw";
        $cash->amount = $request->amount;
        $cash->title = "Withdrawn to Bank";
        $cash->date = $request->date;
        $cash->save();

        $bankDeposit = new BankDeposit;
        $bankDeposit->bank_account_id = $request->account;
        $bankDeposit->type = $request->type;
        $bankDeposit->bankAccount->balance += $request->amount;
        $bankDeposit->amount = $request->amount;
        $bankDeposit->date_of_issue = $request->date;
        $bankDeposit->entry_by = Auth::user()->name;
        $bankDeposit->push();

        toastr()->success('Withdrawn Successfully');
        return redirect('/admin/cash-register');
    }

    public function depositFromBankForm()
    {
        $bankAccounts = BankAccount::all();
        return view('cash-register.deposit-from-bank', compact('bankAccounts'));
    }

    public function depositFromBank(Request $request)
    {
        $request->validate([
            'account'=>'required',
            'type'=>'required',
            'cheque_no'=>'nullable|required_if:type,Cheque',
            'card'=>'nullable|required_if:type,Card',
            'validity'=>'nullable|required_if:type,Card',
            'cvv'=>'nullable|required_if:type,Card',
            'amount'=>'required|numeric|gt:0|lte:'.$request->account->balance,
            'date'=>'required|before_or_equal:today',
        ]);

        $cash = new CashRegister;
        $cash->type = "Deposit";
        $cash->amount = $request->amount;
        $cash->title = "Deposited from Bank";
        $cash->date = $request->date;
        $cash->save();

        $bankWithdraw = new BankWithdraw;
        $bankWithdraw->bank_account_id = $request->account;
        $bankWithdraw->type = $request->type;
        $bankWithdraw->bankAccount->balance -= $request->amount;
        $bankWithdraw->amount = $request->amount;
        $bankWithdraw->date_of_issue = $request->date;
        $bankWithdraw->entry_by = Auth::user()->name;
        $bankWithdraw->push();

        toastr()->success('Deposited Successfully');
        return redirect('/admin/cash-register');
    }
}
