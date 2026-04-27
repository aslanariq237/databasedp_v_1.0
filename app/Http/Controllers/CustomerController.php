<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Customer::all();
        return view('container.pages.home', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $customer = new Customer();
        $customer->nama_toko = $request->nama_toko;
        $customer->kode_toko = $request->kode_toko;
        $customer->Toko = $request->Toko;
        $customer->pic = $request->pic;
        $customer->no_telp = $request->no_telp;
        $customer->NPWP = $request->NPWP;
        $customer->alamat = $request->alamat;
        if ($customer->save()) {            
            return ["status" => "Data Customer telah di Tambahkan"];
        }else{
            return ["status" => "Data Gagal di Tambahkan"];
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
