<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function edit(Request $request){
        $id_barang = $request->input('id_barang');

        if ($request->nama_barang) {
            $barang = DB::table('detailbarang')->where('id', $id_barang)->update([
                'nama_barang' => $request->nama_barang,
            ]);   
        }      
        
        if ($request->sn) {
            $barang = DB::table('detailbarang')->where('id', $id_barang)->update([
                'SN' => $request->sn
            ]);
        }

        if ($request->id_customer) {
            $barang = DB::table('detailbarang')->where('id', $id_barang)->update([
                'id_customer' => $request->id_customer
            ]);
        }
        return redirect()->back()->with('success', 'Berhasil Mengedit Data');
    }
    public function searchSN() {        
        $sn = null;

        $tandater = DB::table('detailbarang')
            ->join('tandater', 'detailbarang.id_tandater', '=', 'tandater.id_tandater')
            ->join('customer', 'detailbarang.id_customer', '=', 'customer.id')
            ->where('detailbarang.SN', $sn)
            ->first();

        return view('container.pages.search', compact('tandater'));
    }

    public function searchBySN(Request $request){
        $sn = $request->input('serial_number');

        $tandater = DB::table('detailbarang')
            ->join('tandater', 'detailbarang.id_tandater', '=', 'tandater.id_tandater')
            ->leftJoin('customer', 'detailbarang.id_customer', '=', 'customer.id')
            ->where('detailbarang.SN', $sn)
            ->first();
        
        return view('container.pages.search', compact('tandater'));
        
    }
}
