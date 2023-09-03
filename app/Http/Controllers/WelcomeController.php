<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Respon;
use App\Models\User;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $totalUser = User::all()->count();
        $totalAduanSelesai = Complaint::where('status', 'selesai')->count();
        $totalRespon = Respon::all()->count();
        return view('dashboard.welcome', [
            'totalUser' => $totalUser,
            'totalAduanSelesai' => $totalAduanSelesai,
            'totalRespon' => $totalRespon
        ]);
    }
}
