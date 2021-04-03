<?php

namespace App\Http\Controllers;

use App\BankAccount;
use App\BankDeposit;
use App\BankWithdraw;
use App\CashRegister;
use App\Client;
use App\ClientPayment;
use App\Entry;
use App\Godown;
use App\Invoice;
use App\Product;
use App\ProductTransfer;
use App\Supplier;
use App\SupplierPayment;
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

    public function trash()
    {
        $products = Product::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'products');
        $suppliers = Supplier::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'suppliers');
        $entries = Entry::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'entries');
        $supplierPayments = SupplierPayment::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'supplier-payments');
        $clients = Client::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'clients');
        $invoices = Invoice::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'invoices');
        $clientPayments = ClientPayment::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'client-payments');
        $godowns = Godown::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'godowns');
        $cashs = CashRegister::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'cash-registers');
        $bankAccounts = BankAccount::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'bank-accounts');
        $bankDeposits = BankDeposit::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'bank-deposits');
        $bankWithdraws = BankWithdraw::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'bank-withdraws');
        $productTransfers = ProductTransfer::onlyTrashed()->orderBy('deleted_at','desc')->paginate(1, ['*'], 'product-transfers');
        return view('trash', compact('products','suppliers','entries','supplierPayments','clients','invoices','clientPayments','godowns','cashs','bankAccounts','bankDeposits','bankWithdraws','productTransfers'));
    }
}
