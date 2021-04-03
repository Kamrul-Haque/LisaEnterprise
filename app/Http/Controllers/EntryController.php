<?php

namespace App\Http\Controllers;

use App\CashRegister;
use App\Entry;
use App\Godown;
use App\Product;
use App\Supplier;
use App\SupplierPayment;
use DB;
use Illuminate\Http\Request;
use Auth;

class EntryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $entries = Entry::latest()->paginate(10);
        return view('entry.index', compact('entries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::orderBy('name')->get();
        $godowns = Godown::orderBy('name')->get();
        $suppliers = Supplier::orderBy('name')->get();
        return view('entry.create', compact('products', 'godowns', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|',
            'quantity' => 'required|numeric|between:0,99999.99',
            'price' => 'required|numeric|between:0,999999999.99',
            'godown' => 'required',
            'supplier' => 'required',
            'date' => 'required|after:31-12-2004|before_or_equal:today',
            'type'=>'required',
            'cheque_no'=>'nullable|required_if:type,Cheque',
            'card'=>'nullable|required_if:type,Card',
            'validity'=>'nullable|required_if:type,Card',
            'cvv'=>'nullable|required_if:type,Card',
            'amount'=>'required|numeric|gte:0|lte:price',
        ]);

        $entry = new Entry;
        $pid = $request->name;
        $gid = $request->godown;
        $quantity = $request->quantity;
        $price = $request->price;

        $entry->product_id = $pid;
        $entry->quantity = $quantity;
        $product = Product::find($pid);
        $entry->unit = $product->unit;
        $entry->buying_price = $price;
        $entry->godown_id = $gid;
        $entry->date = $request->date;
        $entry->supplier_id = $request->supplier;
        $entry->paid = $request->amount;
        $entry->due = $request->due;
        $entry->entry_by = Auth::user()->name;

        if ($request->amount > 0)
            $this->savePayment($request);

        $godown = Godown::find($gid);
        if ($godown->products->contains($pid)){
            $quantity += $godown->products->find($pid)->pivot->quantity;
            $godown->products()->syncWithoutDetaching([$pid => ['quantity'=>$quantity]]);
            $entry->push();
        }
        else{
            $godown->products()->syncWithoutDetaching([$pid => ['quantity'=>$quantity]]);
            $entry->push();
        }
        $id = $entry->id;

        $entry = Entry::find($id);
        $entry->sl_no = 'ENT_'.$id;
        $entry->save();

        toastr()->success('Created Successfully!');
        return redirect('/entries');
    }

    public function savePayment(Request $request)
    {
        $supplierPayment = new SupplierPayment;
        $supplierPayment->supplier_id = $request->supplier;
        $supplierPayment->type = $request->type;

        if ($request->type == 'Cheque')
        {
            $supplierPayment->cheque_no = $request->cheque_no;
            $supplierPayment->status = 'Pending';
        }
        else if ($request->type == 'Card')
        {
            $supplierPayment->card_no = $request->card;
            $supplierPayment->validity = $request->validity;
            $supplierPayment->cvv = $request->cvv;
            $supplierPayment->supplier->total_due += $request->due;
            $supplierPayment->supplier->total_paid += $request->amount;
        }
        else
        {
            $supplierPayment->supplier->total_due += $request->due;
            $supplierPayment->supplier->total_paid += $request->amount;
        }

        $supplierPayment->amount = $request->amount;
        $supplierPayment->date_of_issue = $request->date;
        $supplierPayment->received_by = Auth::user()->name;
        $supplierPayment->push();
        $this->saveWithdraw($request->amount, $request->date);
    }

    public function saveWithdraw($amount, $date)
    {
        $cash = new CashRegister;
        $cash->type = "Withdraw";
        $cash->amount = $amount;
        $cash->title = "Supplier Payment";
        $cash->date = $date;
        $cash->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        return view('entry.show', compact('entry'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $gid = $entry->godown_id;
        $pid = $entry->product_id;

        $godown = Godown::find($gid);
        $gquantity = $godown->products->find($pid)->pivot->quantity - $entry->quantity;
        if ($gquantity && $gquantity>0){
            $godown->products()->updateExistingPivot($pid, ['quantity'=>$gquantity]);
            $entry->delete();
            $entry->product->save();
        }
        else{
            $godown->products()->detach($pid);
            $entry->delete();
            $entry->product->save();
        }

        toastr()->warning('Entry Deleted');
        return redirect('/entries');
    }

    public function destroyAll()
    {
        $products = Product::all();
        foreach ($products as $product)
        {
            $product->godowns()->detach();
        }
        $entries = Entry::all();
        foreach ($entries as $entry)
        {
            $entry->delete();
        }

        DB::statement('ALTER TABLE entries AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE godown_product AUTO_INCREMENT = 0');

        toastr()->error('All Records Deleted!');
        return redirect('/entries');
    }

    public function restore($entry)
    {
        Entry::onlyTrashed()->find($entry)->restore();

        $entry = Entry::find($entry);
        $gid = $entry->godown_id;
        $pid = $entry->product_id;
        $quantity = $entry->quantity;

        $godown = Godown::find($gid);
        if ($godown->products->contains($pid)){
            $quantity += $godown->products->find($pid)->pivot->quantity;
            $godown->products()->syncWithoutDetaching([$pid => ['quantity'=>$quantity]]);
            $entry->push();
        }
        else{
            $godown->products()->syncWithoutDetaching([$pid => ['quantity'=>$quantity]]);
            $entry->push();
        }

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($entry)
    {
        Entry::onlyTrashed()->find($entry)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }
}
