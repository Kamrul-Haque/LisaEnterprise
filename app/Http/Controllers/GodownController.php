<?php

namespace App\Http\Controllers;

use App\Godown;
use App\Entry;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use DB;

class GodownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $godowns = Godown::paginate(10);
        return view('godowns', compact('godowns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create-godown');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $godown = new Godown;
        $godown->name = $request->input('name');
        $godown->location = $request->input('location');
        $godown->phone = $request->input('phone');
        $godown->save();

        toastr()->success('Created Successfully!');
        return redirect('/godowns');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function show(Godown $godown)
    {
        $godown = Godown::find($godown->id);
        $products = $godown->products()->orderBy('name')->paginate(10);
        $entries = $godown->entries()->paginate(10);

        return view('show-godown', compact('products', 'godown', 'entries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function edit(Godown $godown)
    {
        if (Auth::guard('admin')->check())
        {
            $godown = Godown::find($godown->id);
            return view('edit-godown', compact('godown'));
        }
        else
        {
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Godown $godown)
    {
        $this->validate($request,[
            'name' => 'required',
            'location' => 'required',
            'phone' => 'required|numeric'
        ]);

        $godown = Godown::find($godown->id);
        $godown->name = $request->input('name');
        $godown->location = $request->input('location');
        $godown->phone = $request->input('phone');
        $godown->save();

        toastr()->success("Updated Successfully!");
        return redirect('/godowns');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function destroy(Godown $godown)
    {
        $godown = Godown::find($godown->id);
        $godown->delete();

        toastr()->warning("Entry Deleted!");
        return redirect('/godowns');
    }

    public function destroyAll()
    {
        $godowns = Godown::all();
        foreach ($godowns as $godown)
        {
            $godown->delete();
        }
        DB::statement('ALTER TABLE godowns AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE entries AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE godown_product AUTO_INCREMENT = 0');

        toastr()->error('All Records Deleted!');
        return redirect('/godowns');
    }

    public function transferForm(Godown $godown, Product $product)
    {
        $godowns = Godown::all();
        return view('product-transfer', compact('product', 'godown', 'godowns'));
    }

    public function transfer(Request $request)
    {
        $this->validate($request,[
            'quantity' => 'required|numeric',
            'tgodown' => 'required',
            'date' => 'required',
        ]);

        $gid = $request->godown;
        $pid = $request->product;
        $quantity = $request->quantity;

        $product = Product::find($pid);
        $godown = Godown::find($gid);
        $gquantity = $godown->products->find($pid)->pivot->godown_quantity - $quantity;
        if ($gquantity>0){
            $godown->products()->updateExistingPivot($pid, ['godown_quantity'=>$gquantity]);
        }
        else{
            $godown->products()->detach($pid);
        }

        $newEntry = new Entry;
        $newEntry->product_id = $pid;
        $newEntry->quantity = $quantity;
        $newEntry->unit = $product->unit;
        $newEntry->buying_price = $product->unit_buying_price * $quantity;
        $newEntry->godown_id = $request->tgodown;
        $newEntry->date = $request->date;
        $newEntry->bought_from = $request->cgodown;
        $newEntry->entry_by = Auth::user()->name;

        $godown = Godown::find($request->tgodown);
        if ($godown->products->contains($pid)){
            $quantity += $godown->products->find($pid)->pivot->godown_quantity;
            $godown->products()->updateExistingPivot($pid, ['godown_quantity'=>$quantity]);
            $newEntry->save();
        }
        else{
            $godown->products()->syncWithoutDetaching($pid, ['godown_quantity'=>$quantity]);
            $newEntry->save();
        }

        $id = $newEntry->id;

        $newEntry = Entry::find($id);
        $newEntry->sl_no = 'ENT_'.$id;
        $newEntry->save();

        toastr()->success('Created Successfully!');
        return redirect('/admin/entries');
    }
}
