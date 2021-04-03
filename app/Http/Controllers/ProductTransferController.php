<?php

namespace App\Http\Controllers;

use App\Godown;
use App\Product;
use App\ProductTransfer;
use Illuminate\Http\Request;

class ProductTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productTransfers = ProductTransfer::latest()->paginate(10);
        return view('product-transfer.index', compact('productTransfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product, Godown $godown)
    {
        $godowns = Godown::all();
        $avlQuantity = $product->godowns()->find($godown)->pivot->quantity;
        return view('product-transfer.create', compact('product','godown','avlQuantity','godowns'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'to'=>'required',
           'transferQuantity'=>'required|numeric|gt:0|lte:avlQuantity',
           'date'=>'required|after_or_equal:today',
        ]);

        $productTransfer = new ProductTransfer();
        $productTransfer->product_id = $request->product;
        $productTransfer->godown_from = $request->from;
        $productTransfer->godown_to = $request->to;
        $productTransfer->quantity = $request->transferQuantity;
        $productTransfer->date = $request->date;
        $productTransfer->entry_by = auth()->user()->name;

        //update stock
        $godownTo = Godown::find($request->to);
        if ($godownTo->products()->find($request->product) != null){
            $gquantity = $godownTo->products()->find($request->product)->pivot->quantity + $request->transferQuantity;
            $godownTo->products()->updateExistingPivot($request->product, ['quantity'=>$gquantity]);
        }
        else{
            $godownTo->products()->syncWithoutDetaching([$request->product => ['quantity'=>$request->transferQuantity]]);
        }

        //deal with existing stock
        $godownFrom = Godown::find($request->from);
        $gquantity = $godownFrom->products->find($request->product)->pivot->quantity - $request->transferQuantity;
        if ($gquantity>0){
            $godownFrom->products()->updateExistingPivot($request->product, ['quantity'=>$gquantity]);
        }
        else{
            $godownFrom->products()->detach($request->product);
        }
        $productTransfer->save();

        $productTransfer->sl_no = "PTFR_".$productTransfer->id;
        $productTransfer->save();

        toastr()->success('Transferred Successfully');
        return redirect('/product-transfers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductTransfer  $productTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy($productTransfer)
    {
        $productTransfer = ProductTransfer::find($productTransfer);
        $productTransfer->delete();

        toastr()->warning('Record Deleted');
        return redirect('/product-transfers');
    }

    public function restore($productTransfer)
    {
        ProductTransfer::onlyTrashed()->find($productTransfer)->restore();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($productTransfer)
    {
        ProductTransfer::onlyTrashed()->find($productTransfer)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }
}
