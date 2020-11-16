<?php

namespace App\Http\Controllers;

use App\Entry;
use App\Godown;
use App\Product;
use App\Supplier;
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
        $godowns = Godown::all();
        $suppliers = Supplier::all();
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
        ]);

        $entry = new Entry;
        $pid = $request->input('name');
        $gid = $request->input('godown');
        $quantity = $request->input('quantity');
        $price = $request->input('price');

        $entry->product_id = $pid;
        $entry->quantity = $quantity;
        $product = Product::find($pid);
        $entry->unit = $product->unit;
        $entry->total_buying_price = $price;
        $entry->unit_buying_price = $price/$quantity;
        $entry->godown_id = $gid;
        $entry->date = $request->input('date');
        $entry->supplier_id = $request->input('supplier');
        $entry->entry_by = Auth::user()->name;

        $godown = Godown::find($gid);
        if ($godown->products->contains($pid)){
            $quantity += $godown->products->find($pid)->pivot->godown_quantity;
            $godown->products()->syncWithoutDetaching([$pid => ['godown_quantity'=>$quantity]]);
            $entry->push();
        }
        else{
            $godown->products()->syncWithoutDetaching([$pid => ['godown_quantity'=>$quantity]]);
            $entry->push();
        }
        $id = $entry->id;

        $entry = Entry::find($id);
        $entry->sl_no = 'ENT_'.$id;
        $entry->save();

        toastr()->success('Created Successfully!');
        return redirect('/admin/entries');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        $entry = Entry::find($entry->id);
        return view('entry.show', compact('entry'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function edit(Entry $entry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entry $entry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $entry = Entry::find($entry->id);
        $quantity = $entry->quantity;
        $price = $entry->buying_price;
        $gid = $entry->godown_id;
        $pid = $entry->product_id;

        $entry->product->total_quantity -= $quantity;
        $entry->product->total_price -= $price;
        if ($entry->product->total_quantity) {
            $entry->product->unit_buying_price = $entry->product->total_price / $entry->product->total_quantity;
        }
        else{
            $entry->product->unit_buying_price = 0;
        }

        $godown = Godown::find($gid);
        $gquantity = $godown->products->find($pid)->pivot->godown_quantity - $quantity;
        if ($gquantity && $gquantity>0){
            $godown->products()->updateExistingPivot($pid, ['godown_quantity'=>$gquantity]);
            $entry->delete();
            $entry->product->save();
        }
        else{
            $godown->products()->detach($pid);
            $entry->delete();
            $entry->product->save();
        }

        toastr()->warning('Entry Deleted');
        return redirect('/admin/entries');
    }

    public function destroyAll()
    {
        $products = Product::all();
        foreach ($products as $product)
        {
            $product->total_quantity = 0;
            $product->total_price = 0;
            $product->unit_buying_price = 0;
            $product->save();
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
        return redirect('/admin/entries');
    }
}
