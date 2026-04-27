<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teknisi;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TeknisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teknisi = Teknisi::all();        
        return view('container.pages.teknisi', compact('teknisi'));
    }

    public function tampil(){
        return Teknisi::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
            $teknisi = new Teknisi();            
            $teknisi->nama_teknisi = $request->nama_teknisi;
            $teknisi->status = $request->status;            
            if ($teknisi->save()) {                                
                return ["success" => "Berhasil Menyimpan Data"];
            }else{                
                return ["Failed" => "Gagal"];
            }
    }
}
