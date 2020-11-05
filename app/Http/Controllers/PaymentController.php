<?php

namespace App\Http\Controllers;

use App\Client;
use App\Payment;
use App\CashRegister;
use Auth;
use DB;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::latest()->paginate(10);
        return view('payments', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('create-payment', compact('clients'));
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
            'client' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required',
        ]);

        $type = $request->input('type');
        $amount = $request->input('amount');

        $payment = new Payment;
        $payment->client_id = $request->input('client');
        $payment->type = $type;
        $payment->amount = $amount;
        $payment->date_of_issue = $request->input('date');
        $payment->received_by = Auth::user()->name;

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

            $payment->client->total_due -= $amount;
            $this->saveDeposit($amount, $request->input('date'), false);
            $payment->push();
        }
        else
        {
            $payment->client->total_due -= $amount;
            $this->saveDeposit($amount, $request->input('date'), false);
            $payment->push();
        }

        $id = $payment->id;
        $payment = Payment::find($id);
        $payment->sl_no = "PYT_".$id;
        $payment->save();

        toastr()->success('Created Successfully!');
        return redirect('/payments');
    }

    public function show(Payment $payment)
    {
        $payment = Payment::find($payment->id);
        return view('show-payment',compact('payment'));
    }

    public function saveDeposit($amount, $date, $sell)
    {
        $cash = new CashRegister;
        $cash->type = "Deposit";
        $cash->amount = $amount;
        if ($sell)
        {
            $cash->title = "Product Sell";
        }
        else
        {
            $cash->title = "Payment";
        }
        $cash->date = $date;
        $cash->save();
    }

    public function edit(Payment $payment)
    {
        $payment = Payment::find($payment->id);
        return view('edit-payment', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $this->validate($request, [
           'status' => 'required'
        ]);

        $payment = Payment::find($payment->id);
        $payment->status = $request->input('status');
        if ($payment->status == 'Drawn')
        {
            $payment->date_of_draw = $request->input('date');
            $payment->client->total_due -= $payment->amount;
            $this->saveDeposit($payment->amount, $request->input('date'), $payment->product_sell);
            $payment->push();
        }
        else
        {
            $payment->save();
        }

        toastr()->info('Updated Successfully!');
        return redirect('/payments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment = Payment::find($payment->id);

        if($payment->status == 'Pending')
        {
            $payment->delete();
        }
        else
        {
            $payment->client->total_due += $payment->amount;
            $payment->push();
            $payment->delete();
        }

        toastr()->warning('Entry Deleted');
        return back();
    }

    public function destroyAll()
    {
        $payments = Payment::all();
        foreach ($payments as $payment)
        {
            if($payment->status == 'Pending')
            {
                $payment->delete();
            }
            else
            {
                $payment->client->total_due += $payment->amount;
                $payment->push();
                $payment->delete();
            }
        }
        DB::statement('ALTER TABLE payments AUTO_INCREMENT = 0');

        toastr()->error('All Records Deleted!');
        return redirect('/payments');
    }
}
