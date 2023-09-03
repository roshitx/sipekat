<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Respon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function dashboard(Request $request)
    {
        $complaintCount = Complaint::all()->count();
        $adminCount = User::where('role', 'admin')->count();
        $petugasCount = User::where('role', 'petugas')->count();
        $masyarakatCount = User::where('role', 'masyarakat')->count();
        $aduanDiproses = Complaint::where('status', 'Sedang Diproses')->count();
        $aduanSelesai = Complaint::where('status', 'Selesai')->count();
        $responDikirim = Respon::all()->count();
        return view('dashboard.dashboard', [
            'masyarakatCount' => $masyarakatCount,
            'adminCount' => $adminCount,
            'petugasCount' => $petugasCount,
            'complaintCount' => $complaintCount,
            'aduanDiproses' => $aduanDiproses,
            'aduanSelesai' => $aduanSelesai,
            'responDikirim' => $responDikirim,
        ]);
    }

        /**
     * Handle the incoming request.
     */
    public function dashboardPetugas(Request $request)
    {
        $complaintCount = Complaint::all()->count();
        $petugasCount = User::where('role', 'petugas')->count();
        $masyarakatCount = User::where('role', 'masyarakat')->count();
        $aduanDiproses = Complaint::where('status', 'Sedang Diproses')->count();
        $aduanSelesai = Complaint::where('status', 'Selesai')->count();
        $responDikirim = Respon::all()->count();
        return view('dashboard.dashboardp', [
            'masyarakatCount' => $masyarakatCount,
            'petugasCount' => $petugasCount,
            'complaintCount' => $complaintCount,
            'aduanDiproses' => $aduanDiproses,
            'aduanSelesai' => $aduanSelesai,
            'responDikirim' => $responDikirim,
        ]);
    }

    public function genderChart()
    {
        $pria = User::where('gender', 'pria')->count();
        $wanita = User::where('gender', 'wanita')->count();
        $lainnya = User::where('gender', 'lainnya')->count();

        return response()->json([
            'pria' => $pria,
            'wanita' => $wanita,
            'lainnya' => $lainnya
        ]);
    }

    public function genderChartPetugas()
    {
        $pria = User::where('gender', 'pria')
                    ->whereIn('role', ['masyarakat', 'petugas'])
                    ->count();

        $wanita = User::where('gender', 'wanita')
                      ->whereIn('role', ['masyarakat', 'petugas'])
                      ->count();

        $lainnya = User::where('gender', 'lainnya')
                       ->whereIn('role', ['masyarakat', 'petugas'])
                       ->count();

        return response()->json([
            'pria' => $pria,
            'wanita' => $wanita,
            'lainnya' => $lainnya
        ]);
    }


    public function getMonthlyComplaintsData()
    {
        $monthlyComplaintsData = Complaint::select(
            DB::raw("DATE_FORMAT(created_at, '%M %Y') as month"),
            DB::raw("COUNT(*) as total")
        )
        ->groupBy('month')
        ->orderBy(DB::raw("DATE_FORMAT(created_at, '%M %Y')"))
        ->get();

        return response()->json($monthlyComplaintsData);
    }
}
