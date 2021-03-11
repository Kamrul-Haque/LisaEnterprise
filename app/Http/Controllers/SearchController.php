<?php

namespace App\Http\Controllers;

use App\CashRegister;
use App\Client;
use App\ClientPayment;
use App\Entry;
use App\Godown;
use App\Invoice;
use App\Payment;
use App\Product;
use App\Supplier;
use App\SupplierPayment;
use Auth;
use Spatie\Searchable\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if (Auth::guard('admin')->check())
        {
            $string = $request->input('search');
            $date = $request->input('date');

            if ($date) $string = $date;

            $searchResults = (new Search())
                ->registerModel(Product::class, 'name')
                ->registerModel(Client::class, 'name','phone')
                ->registerModel(Godown::class, 'name','location')
                ->registerModel(Entry::class, 'sl_no','date')
                ->registerModel(Invoice::class, 'sl_no','date')
                ->registerModel(ClientPayment::class, 'sl_no','date_of_issue','date_of_draw')
                ->registerModel(SupplierPayment::class, 'sl_no','date_of_issue','date_of_draw')
                ->registerModel(Supplier::class, 'name')
                ->registerModel(CashRegister::class, 'title','date')
                ->search($string);

            return view('search-results', compact('searchResults','string'));
        }
        else
        {
            $string = $request->input('search');
            $date = $request->input('date');

            if ($date) $string = $date;

            $searchResults = (new Search())
                ->registerModel(Product::class, 'name')
                ->registerModel(Client::class, 'name','phone')
                ->registerModel(Godown::class, 'name','location')
                ->registerModel(Invoice::class, 'sl_no','date')
                ->registerModel(ClientPayment::class, 'sl_no','date_of_issue','date_of_draw')
                ->registerModel(SupplierPayment::class, 'sl_no','date_of_issue','date_of_draw')
                ->registerModel(Supplier::class, 'name')
                ->search($string);

            return view('search-results', compact('searchResults','string'));
        }
    }
}
