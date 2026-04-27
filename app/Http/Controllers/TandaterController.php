<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teknisi;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Tandater;
use App\Models\Detkel;
use App\Models\Keluhan;
use Illuminate\Support\Facades\Redirect;

class TandaterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {                
        if (!Auth::check()) {
            return redirect()->route('tampil.login');
        }        

        $query = Tandater::query()
            ->with(['Barang'])            
            ->latest();
                
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->input('search_type');    

            $query->where(function ($q) use ($search, $searchType) {
                if (!$searchType || $searchType === 'all') {
                    $q->where('customer', 'like', "%{$search}%")                    
                    ->orWhereHas('Barang', function ($qd) use ($search) {
                        $qd->where('nama_barang', 'like', "%{$search}%")
                            ->orWhere('SN', 'like', "%{$search}%");
                    });
                }
            });
        }

        $tandater = $query
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());
        
        // return response()->json($tandater);
        return view('container.pages.home', compact('tandater'));        
        // $tandater = Tandater::with('Barang')   
        //     ->latest()                  
        //     ->get();  
        
        // $customer = DB::table('tandater')
        //     ->join('customer', 'tandater.id_customer', '=', 'customer.id')
        //     ->select(
        //         'tandater.*',
        //         'customer.nama_toko',
        //         'customer.Toko',
        //         'kode_toko'
        //     )
        //     ->latest()
        //     ->get();                        
    }
    
    public function tampilCust(){
        $customer = DB::table('customer')
            ->latest()
            ->get();
        
        return view('container.pages.customer', compact('customer'));
    }

    public function kel(){
        $tandater = Tandater::with('teknisi')  
            ->latest()          
            ->get();
        
            $customer = DB::table('tandater')
            ->join('customer', 'tandater.id_customer', '=', 'customer.id')
            ->select(
                'tandater.*',
                'customer.nama_toko',
                'customer.Toko',
                'kode_toko'
            )
            ->latest()
            ->get();
        return view('container.pages.keluhan', compact('tandater', 'customer'));        
    }

    public function detKel(string $id) {
        $tandater = DB::table('tandater')
            ->join('detailbarang', 'tandater.id_tandater','=','detailbarang.id_tandater')
            ->join('detkel', 'detailbarang.id','=','detkel.id_barang')
            ->where('detailbarang.id', $id)
            ->get();    

        $customer = DB::table('tandater')
            ->join('customer', 'tandater.id_customer','=','customer.id')            
            ->get();
                    
        return view('container.pages.kelwar', compact('tandater', 'customer'));
    }

    public function check(){
        return Tandater::all();
    }

    public function Fin(Request $request){
        $query = Tandater::query()
            ->with(['Barang'])            
            ->latest();
                
        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->input('search_type');    

            $query->where(function ($q) use ($search, $searchType) {
                if (!$searchType || $searchType === 'all') {
                    $q->where('customer', 'like', "%{$search}%")                    
                    ->orWhereHas('Barang', function ($qd) use ($search) {
                        $qd->where('nama_barang', 'like', "%{$search}%")
                            ->orWhere('SN', 'like', "%{$search}%");
                    });
                }
            });
        }

        $tandater = $query
            ->orderByDesc('created_at')
            ->paginate(15)
            ->appends($request->query());
        // $tandater = Tandater::with('teknisi')
        //     ->latest()
        //     ->get();
                
        // $customer = DB::table('tandater')
        //     ->join('customer', 'tandater.id_customer', '=', 'customer.id')
        //     ->select(
        //         'tandater.*',
        //         'customer.nama_toko',
        //         'customer.Toko',
        //         'kode_toko'
        //     )
        //     ->latest()
        //     ->get();
        return view('container.pages.finance', compact('tandater'));
    }

    public function tampilTT() {        
        $garansi = [
            1 => 'Aktif',
            0 => 'Tidak Aktif'
        ];

        $customer = DB::table('customer')
            ->get();

        return view('container.sidebar.AddTT', compact('garansi', 'customer'));
    }

    public function TampilId(string $id)
    {      
        $tandater = Tandater::where('tandater.id_tandater', $id)
            ->get();          

        $barang = DB::table('detailbarang')
            ->join('tandater', 'detailbarang.id_tandater', '=', 'tandater.id_tandater')
            ->leftJoin('customer', 'detailbarang.id_customer', '=', 'customer.id')
            ->select(
                'tandater.*',
                'detailbarang.*',
                'detailbarang.id as id_barang',
                'detailbarang.status as status_barang',
                'customer.*'
            )
            ->where('tandater.id_tandater', $id)
            ->get();
        
        return view('container.pages.list', compact('tandater', 'barang'));
    }
    
    public function cukel(Request $req){
        $req->validate([            
            'id_teknisi' => 'required',
            'id_keluhan' => 'required|array',
            'id_tandater' => 'required',                
        ]);  
        $id_barang = $req->id_barang;

        $barang = Barang::where('id', $id_barang)->update([            
            'id_teknisi' => $req->id_teknisi
        ]);        

        if (!$req->id_keluhan) {
            return ["Tidak ada data"];
        }else{
            foreach ($req->id_keluhan as $key => $kel) {            
                $keluh = DB::table('keluhan')->where('id', $kel)->first();
                if ($keluh) {
                    DB::table('detkel')->insert([
                        'id_keluhan' => $kel,
                        'nama_keluhan' => $keluh->keluhan,
                        'biaya_keluhan' => $keluh->biaya_keluhan,
                        'id_barang' => $id_barang,
                        'id_tandater' => $req->id_tandater,
                    ]);
                }
            }
        }
        
        if ($req->filled('keluhan')) {
            $keluhanNames = explode(',', $req->keluhan);
            foreach ($keluhanNames as $key => $keluh) {
                DB::table('detkel')->insert([
                    'id_keluhan' => null,
                    'nama_keluhan' => $keluh,
                    'biaya_keluhan' => 5000,
                    'id_barang' => $id_barang,
                    'id_tandater' => $req->id_tandater,
                ]);
            }
        }
        return redirect()->back()->with('Success','Berhasil');
    }

    //UPDATE TEKNISI      

    public function create(Request $request)
    {   
        $request->validate([                    
            'nama_barang' => 'required|array',
            'sn' => 'required|array',  
            'id_customer' => 'required|array'          
        ]);
        try {
            DB::beginTransaction();
            $lastTT = Tandater::latest()->first();
            $lastIdNum = $lastTT ? intval(substr($lastTT->id_tandater, 5)) : 0;
            $newIdNum = $lastIdNum + 1;           
            $id_tandater = 'TT-'. str_pad($newIdNum, 6, '0', STR_PAD_LEFT);            

            $cust = $request->customer;

            $tandater = Tandater::create([
                'id_tandater' => $id_tandater,
                'customer' => $cust,               
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $barang = [];

            $status = 'Pending';

            foreach ($request->nama_barang as $key => $nama){
                array_push($barang, [
                    'id_tandater' => $id_tandater,
                    'id_customer' => $request->id_customer[$key],
                    'nama_barang' => $nama,
                    'status' => $status,
                    'SN' => $request->sn[$key],
                    'garansi' => $request->garansi,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
            Barang::insert($barang);
            DB::commit();
            return redirect()->route('DataCust')->with('success', 'Berhasil');
        } catch (\Execution $e) {
            DB::rollback();
            return redirect()->back()->with('Failed', 'Gagal');
        }                                      
    }

    public function coba(Request $request){
        $data = $request->all();
        dd($data);
    }

    public function show(string $id)
    {          
        $keluhan = DB::table('keluhan')->get();
        $teknisi = Teknisi::get();
        $tandater = Tandater::with('Barang')
            ->where('tandater.id', $id)
            ->get();   

        return view('container.sidebar.AddKel', compact('tandater', 'teknisi', 'keluhan'));
    }
        
    public function viewFinance(string $id){
        $tandater = DB::table('tandater')
            ->join('detailbarang', 'tandater.id_tandater','=','detailbarang.id_tandater')                        
            ->join('detkel','detailbarang.id' ,'=', 'detkel.id_barang')
            ->leftJoin('customer', 'detailbarang.id_customer', '=', 'customer.id')
            ->select(
                'tandater.*',
                'tandater.id', 
                'detailbarang.id_customer',               
                'customer.nama_toko',
                'tandater.id_tandater',                                                  
                'detailbarang.nama_barang',
                'detailbarang.SN',
                'detailbarang.id as id_brg',
                'detkel.id_keluhan',
                'detkel.id as id_kels',            
                'detkel.id as id_barang',
                'detkel.nama_keluhan',
                'detkel.biaya_keluhan',                
                'detailbarang.status',
            ) 
            ->where('tandater.id', $id)            
            ->get();        
        
        $barang = DB::table('tandater')           
            ->join('detailbarang', 'tandater.id_tandater', '=', 'detailbarang.id_tandater')
            ->where('tandater.id', $id)
            ->get();
                    
        return view('container.pages.listKel', compact('tandater', 'barang'));
    }
    
    public function edited_name(Request $req){
        $req->validate([
            'customer_name' => 'required|string'
        ]);

        $tandater = DB::table('tandater')->where('id_tandater', $req->id_tandater)->update([
            'customer' => $req->customer_name
        ]);
        return redirect()->back()->with('success');
    }
}
