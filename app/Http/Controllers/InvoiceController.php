<?php

namespace App\Http\Controllers;

use App\CashRegister;
use App\Client;
use App\Invoice;
use App\InvoiceProduct;
use App\Payment;
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
        return view('invoices', compact('invoices'));
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

        return view('create-invoice', compact('products', 'clients'));
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
            'date' => 'required',
            'name' => 'required',
            'labour' => 'required|numeric',
            'transport' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'discount' => 'required|numeric',
            'gtotal' => 'required|numeric',
            'amount' => 'required|numeric',
            'due' => 'required|numeric',
            'pname.*' => 'required',
            'godown.*' => 'required',
            'quantity.*' => 'required|numeric',
            'unit.*' => 'required',
            'uprice.*' => 'required|numeric',
            'price.*' => 'required|numeric',
        ]);

        $invoice = new Invoice;
        $invoice->date = $request->input('date');
        $invoice->client_id = $request->input('name');
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
                'total_selling_price' => $inputs['price'][$index]
            ];
            $product = Product::find($input);
            $product->total_quantity -= $inputs['quantity'][$index];
            $gquantity = $product->godowns->find($inputs['godown'][$index])->pivot->godown_quantity - $inputs['quantity'][$index];
            if ($gquantity)
            {
                $product->godowns()->updateExistingPivot($inputs['godown'][$index], ['godown_quantity'=>$gquantity]);
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

    public function savePayment($request)
    {
        $type = $request->input('type');
        $amount = $request->input('amount');

        $payment = new Payment;
        $payment->client_id = $request->input('name');
        $payment->type = $type;
        $payment->amount = $amount;
        $payment->received_by = Auth::user()->name;
        $payment->date_of_issue = $request->input('date');
        $payment->product_sell = true;

        if ($type == 'Cheque')
        {
            $payment->acc_no = $request->input('account');
            $payment->status = "Pending";

            $payment->save();
        }
        elseif ($type == 'Card')
        {
            $payment->card_no = $request->input('card');
            $payment->validity = $request->input('validity');
            $payment->cvv = $request->input('cvv');
            $this->saveDeposit($request->input('amount'), $request->input('date'));

            $payment->save();
        }
        else
        {
            $this->saveDeposit($request->input('amount'), $request->input('date'));
            $payment->save();
        }
        $id = $payment->id;
        $payment = Payment::find($id);
        $payment->sl_no = "PYT_".$id;
        $payment->save();

        return $payment->id;
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
        return view('show-invoice', compact('invoice', 'products'));
    }

    public function print(Invoice $invoice)
    {
        $invoice = Invoice::find($invoice->id);
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
        $invoice = Invoice::find($invoice->id);
        foreach ($invoice->invoiceProducts as $invoiceProduct)
        {
            $product = Product::find($invoiceProduct->product_id);
            $product->total_quantity += $invoiceProduct->quantity;
            if ($product->godowns->contains($invoiceProduct->godown_id))
            {
                $gquantity = $product->godowns->find($invoiceProduct->godown_id)->pivot->godown_quantity + $invoiceProduct->quantity;
                $product->godowns()->updateExistingPivot($invoiceProduct->godown_id, ['godown_quantity'=>$gquantity]);
                $product->save();
            }
            else
            {
                $product->godowns()->syncWithoutDetaching($invoiceProduct->godown_id, ['godown_quantity'=>$invoiceProduct->quantity]);
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
}
