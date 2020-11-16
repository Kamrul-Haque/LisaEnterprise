<?php

namespace App\Http\Controllers;

use App\CashRegister;
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
}
