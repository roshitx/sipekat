<?php

namespace App\Http\Controllers;

use App\Models\Respon;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'complaint_id' => 'required',
            'status' => 'required|string',
            'content' => 'required|string'
        ]);

        $complaint = Complaint::where('id', $validatedData['complaint_id'])->first();
        $user = Auth::user();
        $response = new Respon();
        $response->user_id = $user->id;
        $response->complaint_id = $validatedData['complaint_id'];
        $response->content = $validatedData['content'];
        $response->save();

        // Update status aduan di tabel complaint
        $complaint->status = $validatedData['status'];
        $complaint->save();

        return redirect()->back()->with('success', 'Respon berhasil dikirim.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Respon $respon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Respon $respon)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Respon $respon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Respon $respon)
    {
        $respon->delete();

        return back()->with('success', "Respon berhasil di hapus!");
    }
}
