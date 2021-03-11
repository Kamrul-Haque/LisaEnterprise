<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\CashRegister;
use App\Client;
use App\Entry;
use App\Invoice;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //specify middleware for 'admin' guard
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminDashboard()
    {
        $salesToday = Invoice::where('date',Carbon::today()->toDateString())->sum('grand_total');
        $entriesToday = Entry::where('date',Carbon::today()->toDateString())->sum('buying_price');
        $cashBalance = CashRegister::balance();
        $bankBalance = BankAccount::sum('balance');
        $newClients = Client::whereDate('created_at',Carbon::today())->count();
        $newSuppliers = Supplier::whereDate('created_at',Carbon::today())->count();
        return view('admin-dashboard', compact('salesToday','entriesToday','cashBalance','bankBalance','newClients','newSuppliers'));
    }

    //logout for admin
    public function adminLogout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
