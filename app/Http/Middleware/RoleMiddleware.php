<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') 
            {
                return redirect()->route('admin.tampil');
            } elseif ($user->role === 'user') 
            {
                return redirect()->route('DataCust');
            } elseif($user->role === 'teknisi') 
            {
                return redirect()->route('DataKel');
            } elseif ($user->role === 'finance') 
            {
                return redirect()->route('DataFin');
            }
            else{
                return redirect()->back()->with('Failed','daftar menggunakan akun yang sesuai');
            }
        }
        return redirect()->back()->with('error');
        return $next($request);
    }
}
