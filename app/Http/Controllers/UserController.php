<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Tandater;
use App\Models\Barang;
use App\Models\Finish;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function adminDashboard(){
        $tandater = Tandater::with('Barang')   
            ->latest()                  
            ->get();   
        $customer = DB::table('tandater')
            ->join('customer','tandater.id_customer', '=', 'customer.id')
            ->get(); 

        $finishes = Finish::get();

        // dd($tandater);
        return view('admin.adminPages.detailTandater', compact('tandater', 'finishes', 'customer'));
    }

    public function Regis(){
        return view('Auth/Regis');
    }
    public function Login(){
        return view('Auth.Login');
    }

    function adminLog(){
        return view('Auth.LogAdmin');
    }

    function tekLogin(){
        return view('Auth.LogTek');
    }
    
    function finLog(){
        return view('Auth.LogFin');
    }
    public function loginFinance(Request $request){
        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::User();

            if ($user->hasRole('admin')) {
                return redirect()->route('dashboard');
            }
            return redirect()->route('dashboard');
        }

    }

    public function loginAdmin(Request $request){
        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::User();

            if ($user->hasRole('finance')) {
                return redirect()->route('DataFin');
            }
        }
    }

    public function loginTeknisi(Request $request){
        $data = $request->only('email', 'password');

        if (Auth::attempt($data)) {
            $user = Auth::User();

            if ($user->hasRole('teknisi')) {
                return redirect()->route('DataKel');
            }
        }
    }

    // post

    public function Reg(Request $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->created_at = now();
        $user->updated_at = now();
        if ($user) {          
            $user->assignRole('teknisi');  
            $user->save();        
        }else{
            return ["status" => "Gagal Registrasi"];
        }
        return redirect()->route('tampil.login');
    }
    
    public function Log(Request $request){
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $user = Auth::user();
          if ($user->hasRole('user')) {
            return redirect()->route('DataCust');  
          }
        }else {
            return redirect()->back()->with('gagal', "Email atau Password salah");
        }
    }

    public function LogAdmin(Request $request)
    {
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $user = Auth::user();
          if ($user->hasRole('admin')) {
            return redirect()->route('Dashboard');  
          }
        }else {
            return redirect()->back()->with('gagal', "Email atau Password salah");
        }
    }

    public function LogFin(Request $request)
    {
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $user = Auth::user();
          if ($user->hasRole('finance')) {
            return redirect()->route('DataFin');  
          }
        }else {
            return redirect()->back()->with('gagal', "Email atau Password salah");
        }
    }

    public function LogTek(Request $request)
    {
        $data = $request->only('email', 'password');
        if (Auth::attempt($data)) {
            $user = Auth::user();
          if ($user->hasRole('teknisi')) {
            return redirect()->route('DataKel');  
          }
        }else {
            return redirect()->back()->with('gagal', "Email atau Password salah");
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('tampil.login');
    }
}
