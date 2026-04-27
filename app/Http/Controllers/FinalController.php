<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Finish;
use App\Models\Teknisi;
use App\Models\Barnis;
use App\Models\Transaksi;
use App\Models\Barang;
use PDF;
use Excel;
use App\Models\Customer;
use App\Models\Detkel;
use App\Models\Tandater;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Carbon\Carbon;
use App\Exports\ExportTransaksi;
use App\Exports\ExportTeknisi;

class FinalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function TransExport(Request $req){                
        $start_at = Carbon::parse($req->start_date)->startOfDay();        
        $end_at = Carbon::parse($req->end_date)->startOfDay();                
        return Excel::download(new ExportTransaksi($start_at, $end_at), 'transaksi.xlsx');                
    }

    public function TeknExport(Request $req){
        $startDate = $req->input('start_date');
        $endDate = $req->input('end_date');

        return Excel::download(new ExportTeknisi($startDate, $endDate), 'TeknisiExport.xlsx');
        return redirect()->back()->with('success');
    }
    public function bap (string $id) {
        $transaksi = DB::table('transaksi')
            ->join('finishes','transaksi.id_final','=','finishes.id_final')
            ->join('tandater', 'transaksi.id_tandater','=','tandater.id_tandater')             
            ->leftJoin('customer', 'transaksi.id_customer','=','customer.id')
            ->select(
                'finishes.*',
                'tandater.*',
                'customer.*',
                'transaksi.id_customer',                
                'transaksi.no_invoice as no_invoice',
                'transaksi.created_at as tanggalnow',
                'transaksi.jasa_service as jasa_service',
                'transaksi.total_biaya as totalbiaya',
                'transaksi.ppn as ppn',  
            )
            ->where('transaksi.id_transaksi', $id)
            ->get(); 
        
        $nambar = DB::table('barnis') 
            ->join('transaksi', 'barnis.id_transaksi', '=', 'transaksi.id_transaksi')               
            ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
            ->select(
                'detailbarang.*',
                'transaksi.total_biaya as totalbiaya'
            )
            ->where('transaksi.id_transaksi', $id)
            ->get();

        $namber = DB::table('barnis') 
                ->join('transaksi', 'barnis.id_transaksi', '=', 'transaksi.id_transaksi')               
                ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
                ->join('detkel', 'detailbarang.id', '=', 'detkel.id_barang')
                ->select(
                    'detailbarang.*',
                    'detkel.*',
                    'transaksi.total_biaya as totalbiaya'
                )
                ->where('transaksi.id_transaksi', $id)
                ->get();
        
        $data = [
            'transaksi' => $transaksi,            
            'namber' => $namber,
            'nambar' => $nambar
        ];

        $pdf = PDF::loadView('container.folder.bap', $data);
        return $pdf->stream('invoice_DC_bandung.pdf'); 
    }

    public function search(Request $request)
    {
        $query = $request->get('query');
        $customers = Customer::where('nama_toko', 'like', "%$query%")
            ->orWhere('kode_toko', 'like', "%$query%")
            ->get();

        return response()->json($customers);
    }    

    public function downPdf(Request $req){
        $ids = $req->ids;
        $kwit = $req->kwitansi;
        $sph = $req->sph;
        $inv = $req->invoice;
        $pen = $req->penawaran;
        $bap = $req->bap;

        function numberToWords($number) {
            $words = array(
                0 => null, 1 => 'Satu', 2 => 'Dua', 3 => 'Tiga', 4 => 'Empat', 
                5 => 'Lima', 6 => 'Enam', 7 => 'Tujuh', 8 => 'Delapan', 9 => 'Sembilan',
                10 => 'Sepuluh', 11 => 'Sebelas', 12 => 'Dua Belas', 13 => 'Tiga Belas', 
                14 => 'Empat Belas', 15 => 'Lima Belas', 16 => 'Enam Belas', 
                17 => 'Tujuh Belas', 18 => 'Delapan Belas', 19 => 'Sembilan Belas', 
                20 => 'Dua Puluh', 30 => 'Tiga Puluh', 40 => 'Empat Puluh', 
                50 => 'Lima Puluh', 60 => 'Enam Puluh', 70 => 'Tujuh Puluh', 
                80 => 'Delapan Puluh', 90 => 'Sembilan Puluh'
            );
        
            $suffixes = array(
                100 => 'Ratus', 
                1000 => 'Ribu', 
                1000000 => 'Juta', 
                1000000000 => 'Miliar'
            );
        
            if ($number < 0) {
                return "Minus " . numberToWords(abs($number));
            }
        
            if ($number <= 20) {
                return $words[$number];
            } elseif ($number < 100) {
                return $words[10 * floor($number / 10)] . ' ' . numberToWords($number % 10);
            } elseif ($number < 1000) {
                return $words[floor($number / 100)] . ' ' . $suffixes[100] . ' ' . numberToWords($number % 100);
            } elseif ($number < 1000000) {
                return numberToWords(floor($number / 1000)) . ' ' . $suffixes[1000] . ' ' . numberToWords($number % 1000);
            } elseif ($number < 1000000000) {
                return numberToWords(floor($number / 1000000)) . ' ' . $suffixes[1000000] . ' ' . numberToWords($number % 1000000);
            } elseif ($number < 1000000000000) {
                return numberToWords(floor($number / 1000000000)) . ' ' . $suffixes[1000000000] . ' ' . numberToWords($number % 1000000000);
            }
        
            return '';
        }

        

        $transaksi = DB::table('transaksi')
            ->leftJoin('finishes','transaksi.id_final','=','finishes.id_final')            
            ->join('tandater', 'transaksi.id_tandater','=','tandater.id_tandater')             
            ->leftJoin('customer', 'transaksi.id_customer', '=','customer.id')
            ->select(
                'finishes.*',
                'tandater.*',
                'customer.*',
                'tandater.customer',
                'transaksi.id_transaksi',
                'transaksi.id_customer',
                'transaksi.no_invoice as no_invoice',
                'transaksi.created_at as tanggalnow',
                'transaksi.total_biaya as totalbiaya',
                'transaksi.jasa_service as jasa_service',
                'transaksi.ppn as ppn',  
            )
            ->where('transaksi.id_transaksi', $ids)
            ->get();

        $nambar = DB::table('barnis') 
            ->join('transaksi', 'barnis.id_transaksi', '=', 'transaksi.id_transaksi')               
            ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
            ->select(
                'detailbarang.*',
                'transaksi.total_biaya as totalbiaya'
            )
            ->where('transaksi.id_transaksi', $ids)
            ->get();  

        $nama_barang = DB::table('barnis')
            ->join('transaksi', 'barnis.id_transaksi','=','transaksi.id_transaksi')
            ->join('detailbarang','barnis.id_barang','=','detailbarang.id')                     
            ->select(                
                'transaksi.*',
                'transaksi.total_biaya as totalbiaya',
                'transaksi.ppn as ppns',  
                'detailbarang.*'              
            )  
            ->where('transaksi.id_transaksi', $ids)
            ->get();

            $total_biaya = $transaksi->map(function($item){                
                $item->total_biaya = numberToWords($item->totalbiaya + $item->ppn);                
                return $item->total_biaya;
            });

        $namber = DB::table('barnis')
            ->leftJoin('transaksi', 'barnis.id_transaksi', '=', 'transaksi.id_transaksi')
            ->leftJoin('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
            ->leftJoin('detkel', 'barnis.id_barang', '=', 'detkel.id_barang')
            ->select(
                'transaksi.*',
                'transaksi.total_biaya as totalbiaya',
                'detailbarang.*',
                'detailbarang.id as id_barang',
                'detkel.*',
            )
            ->where('transaksi.id_transaksi', $ids)
            ->get();
            
        $penawaran = DB::table('barnis')
        ->join('transaksi', 'barnis.id_transaksi', '=', 'transaksi.id_transaksi')
        ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
        ->join('detkel', 'barnis.id_barang', '=', 'detkel.id_barang')
        ->select(
            'transaksi.*',
            'transaksi.total_biaya as totalbiaya',
            'detailbarang.*',
            'detailbarang.id as id_barang',
            'detkel.*',
        )
        ->where('transaksi.id_transaksi', $ids)
        ->whereIn('detailbarang.status', ['Penawaran', 'Selesai', 'Pending'])
        ->get();

            $data = [
                'transaksi' => $transaksi,
                'nama_barang' => $nama_barang,
                'nambar' => $nambar,
                'total_biaya' => $total_biaya,
                'namber' => $namber,
                'penawaran' => $penawaran
            ];
        
        $pdffiles = [];
        
        if ($kwit) {            
            $pdf = PDF::loadView('container.folder.kwitansi', $data);
            $pdf->set_option('dpi','120');
            return $pdf->stream('Kwitansi.pdf');            
        }

        if ($sph != 0) {
            $pdf = PDF::loadView('container.folder.sph', $data);            
            $pdf->set_option('dpi','120');
            return $pdf->stream('SuratJalan.pdf');
        }

        if ($inv != 0) {   
            $pdf = new PDF();
            $pdf = PDF::loadView('container.folder.inpois', $data);
            $pdf->set_option('dpi','120');
            return $pdf->stream('Invoice.pdf');
        }   
        if ($pen != 0) {
            $pdf = PDF::loadView('container.folder.penawaran', $data);            
            $pdf->set_option('dpi','120');
            return $pdf->stream('penawaran.pdf');
        }         
        if($bap != 0){
            $pdf = PDF::loadView('container.folder.bap', $data);
            $pdf->set_option('dpi', '120');
            return $pdf->stream('invoice_DC_bandung.pdf'); 
        }           

        return redirect()->back()->with('Success',' Berhasil Mendownload Data');
    }

    public function TeknisiList(){
        $teknisi = DB::table('teknisi')->get();
        return view('container.pages.teknisi', compact('teknisi'));
    }

    public function penawaran(string $id){
        $transaksi = DB::table('transaksi')
            ->join('tandater', 'transaksi.id_tandater', '=', 'tandater.id_tandater')
            ->join('customer', 'tandater.id_customer', '=', 'customer.id')
            ->where('id_transaksi', $id)
            ->select(
                'transaksi.id',                           
                'transaksi.created_at as tanggalnow',
                'transaksi.total_biaya as totalbiaya',
                'transaksi.ppn as ppn',
                'transaksi.jasa_service',
                'customer.*'
            )
            ->get();

        $namber = DB::table('barnis')
        ->join('transaksi', 'barnis.id_transaksi','=','transaksi.id_transaksi')
        ->join('detailbarang','barnis.id_barang','=','detailbarang.id')                             
        ->join('detkel', 'barnis.id_barang', '=', 'detkel.id_barang')
        ->select(                
            'transaksi.*',
            'transaksi.total_biaya as totalbiaya',
            'transaksi.ppn as ppns',  
            'detailbarang.*',
            'detkel.*'                      
        )  
        ->where('transaksi.id_transaksi', $id)
        ->get();        
        return view('container.folder.penawaran', compact('namber', 'transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function DataTransaksi(Request $request){
        $query = DB::table('transaksi')
            ->join('finishes','transaksi.id_final','=','finishes.id_final')
            ->join('tandater', 'transaksi.id_tandater','=','tandater.id_tandater')                         
            ->join('barnis', 'transaksi.id_transaksi', '=', 'barnis.id_transaksi')
            ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
            ->leftJoin('customer', 'transaksi.id_customer','=','customer.id')            
            ->select(
                'finishes.*',
                'tandater.*',
                'barnis.*',
                'detailbarang.*',
                'customer.*',
                'transaksi.id',
                'transaksi.id_customer',                
                'transaksi.no_invoice as no_invoice',
                'transaksi.created_at as tanggalnow',
                'transaksi.jasa_service as jasa_service',
                'transaksi.total_biaya as totalbiaya',
                'transaksi.status_pay',
                'transaksi.ppn as ppn',  
                'transaksi.created_at',
            )   
            ->orderBy('transaksi.id_transaksi', 'desc');

            if ($request->filled('search')) {
                $search = $request->search;
                $searchType = $request->input('search_type');    

                $query->where(function ($q) use ($search, $searchType) {
                    if (!$searchType || $searchType === 'all') {
                        $q->where('id_transaksi', 'like', "%{$search}%")                    
                        ->orWhere('no_invoice', 'like', "%{$search}%");                    
                    }
                });
            }

            $transaksi = $query
                ->paginate(15)
                ->appends($request->query());   
                
        return view('container.pages.transaksiData', compact('transaksi'));
    }
    public function create(Request $req)
    {
        $req->validate([
            'id_barang' => 'required|array',
            'id_tandater' => 'required',
            'customer' => 'required',            
            'jasa_service' => 'required'
        ]);        
        $has_created = DB::table('tandater')->where('id_tandater', $req->id_tandater)->value('has_created');
        if($has_created !=1){}
            $id_barang = $req->input('id_barang');
        
            foreach ($id_barang as $id_bar) {
                $bartot = DB::table('detailbarang')
                    ->join('detkel', 'detailbarang.id', '=', 'detkel.id_barang')            
                    ->groupBy('detkel.id_barang')            
                    ->where('detkel.id_barang', $id_bar)            
                    ->sum('detkel.biaya_keluhan');
                
                $barang = Barang::where('id', $id_bar)->update([
                    'cost' => $bartot
                ]);
            } 
            
            $customer = DB::table('customer')->where('id', $req->customer)->first();

            //nomor invoice        

            $total = $req->total_biaya;
            $jasa_service = $req->jasa_service;
            $persen = 12 * 1/100;        
                    
            $cost = $total + $jasa_service;        
            $dpp = $cost * 11/12;
            $ppn = $dpp * $persen;        
            $id_tandater = $req->id_tandater;        
            $status_pay = 0;      

            $finish = Finish::create([
                'id_tandater' => $id_tandater,  
                'total_biaya' => $cost,                        
                'jasa_service' => $jasa_service,           
                'ppn' => $ppn,
                'status_pay' => $status_pay,    
                'created_at' => now()            
            ]);             
                
            DB::commit();
            return redirect()->back()->with('Success', 'Success to Load The Data');
        }else{
            return redirect()->route('DataFin')->with('Data Sudah di Buat');
        }        
    }

    public function Transaksi(Request $req){
        // return response()->json($req);
        $req->validate([
            'id_barang' => 'required|array',
            'id_final'  => 'integer'
        ]);

        try {
            $id_barang_array = $req->input('id_barang');
            $jasa_service = (float) ($req->jasa_service ?? 0);

            $result = DB::transaction(function () use($id_barang_array, $jasa_service, $req)
            {
                $lastT = Transaksi::latest('id')
                        ->lockForUpdate()
                        ->first();                

                $lastIdNum = $lastT ? intval(substr($lastT->id_transaksi, 5)) : 0;
                $newIdNum = $lastIdNum + 1;
                $id_transaksi = 'TR-' . str_pad($newIdNum, 6, '0', STR_PAD_LEFT);
                        
                $id_barang = $req->input('id_barang');   

                $id_customer = DB::table('detailbarang')
                                ->where('id', $id_barang_array)
                                ->value('id_customer');

                // $id_customer = $customerId->first();

                $customer = DB::table('customer')
                            ->where('id', $id_customer);

                $customerName = $customer->nama_toko ?? $id_customer;                                                    
                $currentMonth = date('m');
                $currentYear = date('Y');
                $lastInvoice = Transaksi::latest('id')
                                ->lockForUpdate()
                                ->first();
                $lastInvNum = $lastInvoice
                            ?   intval(explode('/', $lastInvoice->no_invoice[0] ?? 0))
                            : 0;
                $newInvNum = $lastInvNum + 1;
                $no_invoice = sprintf(
                    "%d/DataPrint/%s/%s/%s",
                    $newIdNum,
                    $customerName,
                    $currentMonth,
                    $currentYear
                );

                $cost_barang = DB::table('detailbarang')
                                ->whereIn('id', $id_barang_array)
                                ->sum('cost');
                $total_biaya = $cost_barang + $jasa_service;
                $dpp = $total_biaya * 11/12;
                $ppn = $dpp * (12/100);

                foreach($id_barang_array as $bar){
                    DB::table('barnis')->insert([
                        'id_tandater'      => $req->id_tandater,
                        'id_barang'         => $bar,
                        'id_transaksi'      => $id_transaksi,
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ]);
                }
                $transaksi = Transaksi::create([
                    'id_transaksi'      => $id_transaksi,
                    'no_invoice'        => $no_invoice,
                    'id_customer'       => $id_customer,
                    'id_final'          => $req->id_final,
                    'id_tandater'       => $req->id_tandater,
                    'total_biaya'       => $total_biaya,
                    'jasa_service'      => $jasa_service,
                    'ppn'               => $ppn,
                    'created_at'        => now(),
                    'updated_at'        => now()
                ]);

                return $transaksi;
            });          
            return response()->json($result);
            // return redirect()->route('cetak.list')
            // ->with('success', 'Transaksi berhasil dibuat dengan ID: ' . $result->id_transaksi);
            
        } catch (\Exception $e) {
            \Log::error('Error saat buat transaksi: ' . $e->getMessage());
        
            return redirect()->back()
                ->with('error', 'Gagal membuat transaksi. Silakan coba lagi.')
                ->withInput();
        }

        
        // $id_barang = $req->input('id_barang');
        // $id_cust = DB::table('detailbarang')->whereIn('id', $id_barang)->pluck('id_customer');
        // $id_customer = $id_cust->first();
        
        // $customer = DB::table('customer')->where('id', $id_customer)->first();
        // $lastInvoice = Transaksi::latest()->first();
        // $lastIdNum = $lastInvoice ? intval(explode('/', $lastInvoice->no_invoice)[0]) : 0;            
        // $newIdNum = $lastIdNum + 1;            
        // if (optional($customer)->nama_toko === null) {
        //     $customerName = $id_customer;
        // }else{
        //     $customerName = $customer->nama_toko; 
        // }
        // $currentMonth = date('m'); 
        // $currentYear = date('Y');

        // $no_invoice = sprintf(
        //     "%d/DataPrint/%s/%s/%s",
        //     $newIdNum,
        //     $customerName,
        //     $currentMonth,
        //     $currentYear
        // );        
                    
        // $lastT = Transaksi::latest()->first();
        // $lastIdNum = $lastT ? intval(substr($lastT->id_transaksi, 5)) : 0;
        // $newIdNum = $lastIdNum + 1;           
        // $id_transaksi = 'TR-'. str_pad($newIdNum, 6, '0', STR_PAD_LEFT);
            
        // $cost = 0;
        // foreach ($id_barang as $key => $bar) {
        //     $barnis = DB::table('barnis')->insert([
        //         'id_barang' => $bar,
        //         'id_tandater' => $req->id_tandater,
        //         'id_transaksi' => $id_transaksi,
        //     ]);

        //     $cost += DB::table('detailbarang')
        //         ->where('detailbarang.id', $bar)                
        //         ->sum('detailbarang.cost');
        // }      
        
        // $total_biaya = $cost + $req->jasa_service;
        // $persen = 12 * 1/100;
        // $dpp = $total_biaya * 11/12;     
        // $ppn = $dpp * $persen;

        // $service = $req->jasa_service;
        // $count = $service * count($id_barang);        

        // $transaksi = Transaksi::create([
        //     'id_transaksi' => $id_transaksi,
        //     'id_final' => $req->id_final,
        //     'id_tandater' => $req->id_tandater,
        //     'total_biaya' => $total_biaya,
        //     'no_invoice' => $no_invoice,
        //     'id_customer' => $id_customer,
        //     'ppn' => $ppn,
        //     'jasa_service' => $count,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);        
        // return redirect()->route('cetak.list');
    }

    public function edit(Request $req){
        //status ada di detailbarang
        //harga ada di detkel                

        $id_detbar = $req->id_detbar;
        $id_detkel = $req->id_detkel;        

        if ($req->biaya_keluhan) {
            $keluh = DB::table('detkel')->where('id', $id_detkel)->update([
                'biaya_keluhan' => $req->biaya_keluhan,            
            ]);
        }                

        if ($req->status) {
            $barang = DB::table('detailbarang')->where('id', $id_detbar)->update([
                'status' => $req->status,                  
            ]);
        }    

        $total_biaya = DB::table('detkel')->where('detkel.id_barang', $id_detbar)->sum('detkel.biaya_keluhan');
        
        $cost = DB::table('detailbarang')->where('detailbarang.id', $id_detbar)->update([
            'cost' => $total_biaya,
        ]);        

        return redirect()->back()->with('success', 'berhasil mengedit');
    }
    public function searchDate(Request $request){
        $request->validate([            
            'start_date' => 'required|date',
            'end_date' => 'required|date'        
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $id = $request->input('id_teknisi');

        $teknisi = DB::table('teknisi')            
            ->join('detailbarang', 'teknisi.id_teknisi', '=', 'detailbarang.id_teknisi')
            ->join('tandater', 'detailbarang.id_tandater','=','tandater.id_tandater')
            ->join('customer', 'detailbarang.id_customer', '=', 'customer.id')
            ->select(
                'detailbarang.*',
                'detailbarang.created_at as tanggal',
                'tandater.*',
                'customer.*',
                'teknisi.*',                
            )
            ->where('teknisi.id_teknisi', $id)                        
            ->whereBetween('detailbarang.created_at', [$startDate, $endDate])   
            ->get();  
        
        $nama = DB::table('teknisi')
            ->where('id_teknisi', $id)
            ->get();
        
            
        $data = [
            'nama'=> $nama,
            'teknisi'=> $teknisi,
            'start_date' => $startDate,
            'end_date'=> $endDate
        ];        

        $pdf = PDF::loadView('container.folder.teknisi', $data);
        return $pdf->stream('list_per-teknisi.pdf');
    }
    
    public function tampil(string $id){
        $tandater = DB::table('tandater')
            ->leftJoin('finishes', 'tandater.id_tandater', '=', 'finishes.id_tandater')            
            ->where('tandater.id_tandater', $id)
            ->get();

        $costbarang = DB::table('detailbarang')                    
            ->join('tandater', 'detailbarang.id_tandater','=','tandater.id_tandater')            
            ->join('detkel', 'detailbarang.id', '=', 'detkel.id_barang')
            ->select(                   
                'detkel.id_barang',                
                'detailbarang.nama_barang',
                'detailbarang.id_customer as customerid',
                'detailbarang.SN',  
                'detailbarang.cost as total',          
                'detailbarang.status',                                                
            )            
            ->groupBy('detkel.id_barang', 'detailbarang.nama_barang','detailbarang.id_customer','detailbarang.SN', 'detailbarang.cost', 'detailbarang.status')
            ->where('tandater.id_tandater', $id)
            ->get();
                    
        return view('container.pages.cetak', compact('tandater', 'costbarang'));
    }

    public function Teknisi() {
        $teknisi = DB::table('teknisi')
            ->get();

        return view('admin.adminPages.detailTeknisi', compact('teknisi'));
    }

    public function listTek(string $id){
        $teknisi = DB::table('teknisi')            
            ->join('detailbarang', 'teknisi.id_teknisi', '=', 'detailbarang.id_teknisi')
            ->join('tandater', 'detailbarang.id_tandater','=','tandater.id_tandater')
            ->join('customer', 'detailbarang.id_customer', '=', 'customer.id')
            ->select(
                'detailbarang.*',
                'detailbarang.created_at as tanggal',
                'tandater.*',
                'customer.*',
                'teknisi.*',                
            )
            ->where('teknisi.id_teknisi', $id)            
            ->get();

        $nama = DB::table('teknisi')
            ->where('id_teknisi', $id)
            ->get();
                     
        return view('admin.adminPages.listTeknisis', compact('teknisi', 'nama'));
    }   

    public function paidTr(string $id){
        $paid = DB::table('transaksi')->where('transaksi.id_transaksi', $id)->update([
            'status_pay' => 1,
        ]);

        return redirect()->back()->with('success', 'berhasil mengganti status');
    }

    public function cetaklist(Request $request)
    {     
        $query = DB::table('transaksi')
            ->join('tandater','transaksi.id_tandater','=','tandater.id_tandater')            
            ->join('finishes','transaksi.id_final','=','finishes.id_final')            
            ->leftJoin('customer', 'transaksi.id_customer', '=', 'customer.id')
            ->select(
                'tandater.*',
                'transaksi.*',   
                'customer.*',   
                'transaksi.status_pay',          
                'transaksi.total_biaya as totalbiaya',
                'transaksi.ppn as ppn',                
            )
            ->orderBy('transaksi.id_transaksi', 'desc');                        

        if ($request->filled('search')) {
            $search = $request->search;
            $searchType = $request->input('search_type');    

            $query->where(function ($q) use ($search, $searchType) {
                if (!$searchType || $searchType === 'all') {
                    $q->where('id_transaksi', 'like', "%{$search}%")                    
                    ->orWhere('no_invoice', 'like', "%{$search}%");                    
                }
            });
        }

        $tandater = $query
            ->paginate(15)
            ->appends($request->query());

        // return response()->json($tandater);
        return view('container.pages.cetaklist', compact('tandater'));
    } 

    public function listTak()
    {     
        $tandater = DB::table('transaksi')
            ->join('tandater','transaksi.id_tandater','=','tandater.id_tandater')            
            ->join('finishes','transaksi.id_final','=','finishes.id_final') 
            ->join('barnis', 'transaksi.id_transaksi', '=', 'barnis.id_transaksi')
            ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')           
            ->leftJoin('customer', 'transaksi.id_customer', '=', 'customer.id')
            ->select(
                'tandater.*',
                'transaksi.*',   
                'customer.*',  
                'detailbarang.*',
                'transaksi.status_pay',                
                'transaksi.total_biaya as totalbiaya',
                'transaksi.ppn as ppn',                
            )
            ->get();
        
        $keluhan = DB::table('barnis')
                ->join('detailbarang','barnis.id_barang', '=', 'detailbarang.id')
                ->join('detkel', 'detailbarang.id', '=', 'detkel.id_barang')
                ->get();

                // dd($tandater);
        return view('admin.adminPages.listTak', compact('tandater', 'keluhan'));
    }  
     
    public function editTran(string $id){
        $transaksi = DB::table('transaksi')
            ->where('transaksi.id_transaksi', $id)
            ->get();

        $keluhan = DB::table('barnis') 
            ->join('transaksi', 'barnis.id_transaksi', '=', 'transaksi.id_transaksi')           
            ->join('detailbarang', 'barnis.id_barang','=','detailbarang.id')
            ->join('detkel', 'detailbarang.id','=','detkel.id_barang')
            ->select(
                'transaksi.*',
                'detailbarang.*',
                'detkel.id as id_kels',
                'detkel.*',
                'detailbarang.id as id_brg',
                'detkel.id_keluhan',           
                'detkel.id as id_barang',
            )
            ->where('transaksi.id_transaksi', $id)
            ->get(); 
                
        $total = DB::table('transaksi')
                ->join('barnis', 'transaksi.id_transaksi', '=', 'barnis.id_transaksi')
                ->join('detkel', 'barnis.id_barang', '=', 'detkel.id_barang')
                ->where('transaksi.id_transaksi', $id)
                ->sum('detkel.biaya_keluhan');                

        return view('admin.adminPages.editTransaksi', compact('transaksi', 'keluhan', 'total'));
    } 


    public function editTanggal(Request $req){
        $id_detbar = $req->id_detbar;
        $id_keluhan = $req->id_kels;

        $keluh = DB::table('detkel')->where('id', $id_detkel)->update([
            'biaya_keluhan' => $req->biaya_keluhan,            
        ]);                                
        
        $cost = DB::table('detailbarang')->where('detailbarang.id', $id_detbar)->update([
            'cost' => $total_biaya,
        ]);              

        return redirect()->back()->with('success', 'berhasil mengedit');        
    }

    public function editall(Request $req){   
        $id_transaksi = $req->id_transaksi;            

        $transaksi = DB::table('transaksi')->where('id_transaksi', $id_transaksi)->update([
            'created_at' => $req->date,
        ]);        
              
        $subtotal = $req->totalbiaya;
        $jaser = $req->jasa_service;

        $total = $subtotal + $jaser;
        
        $persen = 12 * 1/100;    
        $dpp = $total * 11/12;
        $ppn = $dpp * $persen;

        $updete = DB::table('transaksi')->where('transaksi.id_transaksi', $id_transaksi)->update([
            'total_biaya' => $total,
            'ppn' => $ppn,
        ]);   

        return redirect()->route('listTak')->with('Success', 'berhasil Mengedit');
    }

    public function deleteKeluhan(string $id, Request $req){
        $keluhan = DB::table('detkel')->where('detkel.id', $id)->delete();

        $total_biaya = DB::table('detkel')->where('detkel.id_barang', $req->id_detbar)->sum('detkel.biaya_keluhan');
        
        $cost = DB::table('detailbarang')->where('detailbarang.id', $req->id_detbar)->update([
            'cost' => $total_biaya,
        ]);  
        return redirect()->back()->with('Telah di Hapus');
    }
    
    public function deleteTransaksi(string $id){
        $find = DB::table('transaksi')->where('id_transaksi', $id)->delete();
        return redirect()->back()->with("Success");
    }

    public function getAlltheData(string $id){        

        $transaksi = DB::table('transaksi')
            ->join('finishes','transaksi.id_final','=','finishes.id_final')
            ->join('tandater', 'transaksi.id_tandater','=','tandater.id_tandater')                         
            ->join('barnis', 'transaksi.id_transaksi', '=', 'barnis.id_transaksi')
            ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')
            ->leftJoin('customer', 'transaksi.id_customer','=','customer.id')            
            ->select(
                'finishes.*',
                'tandater.*',
                'barnis.*',
                'detailbarang.*',
                'customer.*',
                'transaksi.id',
                'transaksi.id_customer',                
                'transaksi.no_invoice as no_invoice',
                'transaksi.created_at as tanggalnow',
                'transaksi.jasa_service as jasa_service',
                'transaksi.total_biaya as totalbiaya',
                'transaksi.status_pay',
                'transaksi.ppn as ppn',  
                'transaksi.created_at',
            )
            ->where('transaksi.id_transaksi', $id)                      
            ->get(); 

        $barang = DB::table('transaksi')
            ->join('barnis', 'transaksi.id_transaksi', '=', 'barnis.id_transaksi')
            ->join('detailbarang', 'barnis.id_barang', '=', 'detailbarang.id')              
            ->where('transaksi.id_transaksi', $id)
            ->get();
        
        $transbtn = DB::table('transaksi')->where('id_transaksi', $id)->get();
        
        return view('container.pages.detailTransaksi', compact('transaksi', 'barang', 'transbtn'));
    }

    public function checking(Request $req){
        $customer = DB::table('transaksi')->where('transaksi.id_transaksi', $req->id_transaksi)
            ->join('tandater', 'transaksi.id_tandater', '=', 'tandater.id_tandater')
            ->leftJoin('customer', 'transaksi.id_customer', '=', 'customer.id')
            ->update([
               'tandater.customer' => $req->customer? $req->customer:"",
               'customer.nama_toko' => $req->nama_toko? $req->nama_toko: "", 
               'customer.Toko' => $req->Toko ? $req->Toko:"",
               'customer.kode_toko' => $req->kode_toko? $req->kode_toko:"",                             
            ]);

        $transaksi = DB::table('transaksi')->where('transaksi.id_transaksi', $req->id_transaksi)->update([
            'id_customer' => $req->id_customer ? $req->id_customer : '',
            'total_biaya' => $req->total_biaya? $req->total_biaya : 0,            
            'jasa_service' => $req->jasa_service ? $req->jasa_service : '',
            'ppn' => $req->ppn,
            'created_at' => $req->tanggalnow,
        ]);

        return redirect()->back()->with('success', 'berhasil mengedit ');
    }
}
