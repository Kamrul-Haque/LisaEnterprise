<?php

namespace App\Http\Controllers;

use App\Client;
use Auth;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('name')->paginate(10);
        return view('client.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
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
            'name' => 'required',
            'email' => 'nullable|email|unique:clients',
            'phone' => 'required|digits:10|unique:clients',
            'address' => 'required',
        ]);

        $client = new Client;
        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->address = $request->input('address');
        $client->total_due = $request->input('dues');
        $client->total_purchase = $request->input('purchase');
        $client->save();

        toastr()->success('Successfully Created!');
        return redirect('/clients');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $invoices = $client->invoices()->paginate(7);
        $payments = $client->clientPayments()->paginate(7);
        return view('client.show', compact('client','invoices', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('client.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'nullable|email|unique:clients,email,'.$client->id,
            'phone' => 'required|digits:10|unique:clients,phone,'.$client->id,
            'address' => 'required',
        ]);

        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->address = $request->input('address');
        $client->total_due = $request->input('dues');
        $client->total_purchase = $request->input('purchase');
        $client->save();

        toastr()->success('Updated Successfully!');
        return redirect('/clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        toastr()->warning('Entry Deleted!');
        return redirect('/clients');
    }

    public function destroyAll()
    {
        DB::table('clients')->delete();

        toastr()->error('All Records Deleted');
        return redirect('/clients');
    }

    public function restore($client)
    {
        Client::onlyTrashed()->find($client)->restore();

        toastr()->success('Entry Restored!');
        return back();
    }

    public function forceDelete($client)
    {
        Client::onlyTrashed()->find($client)->forceDelete();

        toastr()->error('Entry Permanently Deleted!');
        return back();
    }
}
