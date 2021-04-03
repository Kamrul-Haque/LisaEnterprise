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
        $godowns = Godown::orderBy('name')->paginate(10);
        return view('godown.index', compact('godowns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('godown.create');
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
            'location' => 'required',
            'phone' => 'nullable|digits_between:7,10|unique:godowns',
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
        $products = $godown->products()->orderBy('name')->paginate(10);
        $entries = $godown->entries()->paginate(10);

        return view('godown.show', compact('products', 'godown', 'entries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function edit(Godown $godown)
    {
        return view('godown.edit', compact('godown'));
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
            'phone' => 'nullable|digits_between:7,10|unique:godowns,phone,'.$godown->id,
        ]);

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

    public function restore($godown)
    {
        Godown::onlyTrashed()->find($godown)->restore();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($godown)
    {
        Godown::onlyTrashed()->find($godown)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }
}
