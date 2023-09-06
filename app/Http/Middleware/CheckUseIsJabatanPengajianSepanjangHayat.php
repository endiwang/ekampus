<?php

namespace App\Http\Middleware;

use App\Models\Jabatan;
use App\Models\Staff;
use Closure;
use Illuminate\Http\Request;

class CheckUseIsJabatanPengajianSepanjangHayat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $authorize = false;
        $user = auth()->user();
        if($user->is_staff == 1)
        {
            $staff = Staff::where('user_id', $user->id)->first();

            //check jabatan
            $jabatan = Jabatan::where('nama','Jabatan Pengajian Sepanjang Hayat')->first();
            if(!empty($staff) && $staff->jabatan_id == $jabatan->id)
            {
                $authorize = true;
            }
            
        }

        if($authorize)
        {
            return $next($request);
        }
        else {
            abort(403);
        }
    }
}
