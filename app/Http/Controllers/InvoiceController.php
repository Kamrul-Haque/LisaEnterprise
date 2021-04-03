<?php

namespace App\Http\Controllers;

use App\CashRegister;
use App\Client;
use App\ClientPayment;
use App\Invoice;
use App\InvoiceProduct;
use App\Product;
use DB;
use Illuminate\Http\Request;
use Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::latest()->paginate(11);
        return view('invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('invoice.create', compact('products', 'clients'));
    }

    public function getGodowns(Request $request)
    {
        $product = $request->get('id');
        $godowns = Product::find($product)->godowns()->get();

        return response()->json($godowns);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getUnit(Request $request)
    {
        $product = $request->get('id');
        $unit = Product::find($product)->unit;

        return response()->json($unit);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|after:31-12-2004|before_or_equal:today',
            'client' => 'required',
            'labour' => 'required|numeric|between:0,99999.99',
            'transport' => 'required|numeric|between:0,99999.99',
            'subtotal' => 'required|numeric|between:0,999999999.99',
            'discount' => 'required|numeric|between:0,99999.99',
            'gtotal' => 'required|numeric|between:0,999999999.99',
            'amount' => 'required|numeric|between:0,999999999.99',
            'due' => 'required|numeric|between:0,999999999.99',
            'pname.*' => 'required',
            'godown.*' => 'required',
            'quantity.*' => 'required|numeric|between:0,99999.99',
            'unit.*' => 'required',
            'uprice.*' => 'required|numeric|between:0,99999.99',
            'price.*' => 'required|numeric|between:0,99999.99',
            'type'=>'required',
        ]);

        $invoice = new Invoice;
        $invoice->date = $request->input('date');
        $invoice->client_id = $request->input('client');
        $invoice->labour_cost = $request->input('labour');
        $invoice->transport_cost = $request->input('transport');
        $invoice->subtotal = $request->input('subtotal');
        $invoice->discount = $request->input('discount');
        $invoice->grand_total = $request->input('gtotal');
        $invoice->paid = $request->input('amount');
        $invoice->due = $request->input('due');
        $invoice->payment_id = $this->savePayment($request);
        if ($request->input('type') == 'Cheque')
        {
            $invoice->client->total_due += $request->input('gtotal');
        }
        else
        {
            $invoice->client->total_due += $request->input('due');
        }
        $invoice->client->total_purchase += $request->input('gtotal');
        $invoice->push();

        $id = $invoice->id;
        $inputs = $request->all();
        foreach ($inputs['pname'] as $index=>$input)
        {
            $data[] = [
                'invoice_id' => $id,
                'product_id' => $input,
                'godown_id' => $inputs['godown'][$index],
                'quantity' => $inputs['quantity'][$index],
                'unit' => $inputs['unit'][$index],
                'unit_selling_price' => $inputs['uprice'][$index],
                'selling_price' => $inputs['price'][$index]
            ];
            $product = Product::find($input);
            $gquantity = $product->godowns->find($inputs['godown'][$index])->pivot->quantity - $inputs['quantity'][$index];
            if ($gquantity)
            {
                $product->godowns()->updateExistingPivot($inputs['godown'][$index], ['quantity'=>$gquantity]);
                $product->save();
            }
            else
            {
                $product->godowns()->detach($inputs['godown'][$index]);
                $product->save();
            }
        }
        InvoiceProduct::insert($data);

        $invoice = Invoice::find($id);
        $invoice->sl_no = "INV_".$id;
        $invoice->sold_by = Auth::user()->name;
        $invoice->save();

        toastr()->success('Created Successfully!');
        return $this->print($invoice);
    }

    public function savePayment(Request $request)
    {
        $clientPayment = new ClientPayment;
        $clientPayment->client_id = $request->client;
        $clientPayment->type = $request->type;

        if ($request->type == 'Cheque')
        {
            $clientPayment->cheque_no = $request->account;
            $clientPayment->status = 'Pending';
        }
        else if ($request->type == 'Card')
        {
            $clientPayment->card_no = $request->card;
            $clientPayment->validity = $request->validity;
            $clientPayment->cvv = $request->cvv;
            $this->saveDeposit($request->amount, $request->date);
        }
        else
            $this->saveDeposit($request->amount, $request->date);

        $clientPayment->amount = $request->amount;
        $clientPayment->date_of_issue = $request->date;
        $clientPayment->received_by = Auth::user()->name;
        $clientPayment->push();

        return $clientPayment->id;
    }

    public function saveDeposit($amount, $date)
    {
        $cash = new CashRegister;
        $cash->type = "Deposit";
        $cash->amount = $amount;
        $cash->title = "Product Sell";
        $cash->date = $date;
        $cash->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $invoice = Invoice::find($invoice->id);
        $products = $invoice->invoiceProducts()->paginate(7);
        return view('invoice.show', compact('invoice', 'products'));
    }

    public function print(Invoice $invoice)
    {
        return view('layouts.print-invoice', compact('invoice'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        foreach ($invoice->invoiceProducts as $invoiceProduct)
        {
            $product = Product::find($invoiceProduct->product_id);
            if ($product->godowns->contains($invoiceProduct->godown_id))
            {
                $gquantity = $product->godowns->find($invoiceProduct->godown_id)->pivot->quantity + $invoiceProduct->quantity;
                $product->godowns()->updateExistingPivot($invoiceProduct->godown_id, ['quantity'=>$gquantity]);
                $product->save();
            }
            else
            {
                $product->godowns()->syncWithoutDetaching($invoiceProduct->godown_id, ['quantity'=>$invoiceProduct->quantity]);
                $product->save();
            }
        }
        $tdue = $invoice->client->total_due - $invoice->due;
        $tpurchase = $invoice->client->total_purchase - $invoice->grand_total;
        $invoice->client->total_due = $tdue;
        if ($tpurchase>=0)
        {
            $invoice->client->total_purchase = $tpurchase;
            $invoice->push();
            $invoice->delete();
        }
        else
        {

            $invoice->client->total_purchase = 0;
            $invoice->push();
            $invoice->delete();
        }

        toastr()->warning('Entry Deleted');
        return redirect('/invoices');
    }

    public function destroyAll()
    {
        $invoices = Invoice::all();
        foreach ($invoices as $invoice)
        {
            $invoice->client->total_due = 0;
            $invoice->client->total_purchase = 0;
            $invoice->push();
            $invoice->delete();
        }
        DB::statement('ALTER TABLE invoices AUTO_INCREMENT = 0');
        DB::statement('ALTER TABLE invoice_products AUTO_INCREMENT = 0');

        toastr()->error('All Records Deleted');
        return redirect('/invoices');
    }

    public function quotationPrint()
    {
        $clients = Client::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        return view('layouts.print-quotation', compact('products','clients'));
    }

    public function restore($invoice)
    {
        Invoice::onlyTrashed()->find($invoice)->restore();

        $invoice = Invoice::find($invoice);
        foreach ($invoice->invoiceProducts as $invoiceProduct)
        {
            $product = Product::find($invoiceProduct);
            $gquantity = $product->godowns->find($invoiceProduct->godown_id)->pivot->quantity - $invoiceProduct->quantity;
            if ($gquantity)
            {
                $product->godowns()->updateExistingPivot($invoiceProduct->godown_id, ['quantity'=>$gquantity]);
                $product->save();
            }
            else
            {
                $product->godowns()->detach($invoiceProduct->godown_id);
                $product->save();
            }
        }
        $tdue = $invoice->client->total_due + $invoice->due;
        $tpurchase = $invoice->client->total_purchase + $invoice->grand_total;
        $invoice->client->total_due = $tdue;
        $invoice->client->total_purchase = $tpurchase;

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($invoice)
    {
        Invoice::onlyTrashed()->find($invoice)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }
}
