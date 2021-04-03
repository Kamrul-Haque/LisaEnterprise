<?php

namespace App\Http\Controllers;

use App\Product;
use Auth;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name')->paginate(10);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
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
            'unit' => 'required',
        ]);

        $product = new Product;
        $product->name = $request->input('name');
        $product->unit = $request->input('unit');
        $product->save();

        toastr()->success('Created Successfully!');
        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show',compact('product'));
    }

    public function salesIndex()
    {
        $products = Product::with('invoiceProducts.invoice.client')->orderBy('name')->paginate(10);
        return view('product.sales', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request,[
            'name' => 'required',
            'unit' => 'required',
        ]);

        $product = Product::find($product->id);
        $product->name = $request->input('name');
        $product->unit = $request->input('unit');
        $product->save();

        toastr()->success("Updated Successfully!");
        return redirect('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        toastr()->warning('Entry Deleted!');
        return redirect('/products');
    }

    public function destroyAll()
    {
        $products = Product::all();
        foreach ($products as $product)
        {
            $product->delete();
        }
        DB::statement('ALTER TABLE products AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE entries AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE godown_product AUTO_INCREMENT = 0');

        toastr()->error('All Records Deleted!');
        return redirect('/admin/products');
    }

    public function restore($product)
    {
        Product::onlyTrashed()->find($product)->restore();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($product)
    {
        Product::onlyTrashed()->find($product)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }
}
