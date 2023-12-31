<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Enums\ComplaintStatus;
use App\Models\ComplaintImages;
use App\Models\District;
use App\Models\Provincy;
use App\Models\Regency;
use App\Models\Respon;
use App\Models\Village;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::id();
        $ownedComplaint = Complaint::where('user_id', $user)->orderBy('created_at', 'desc')->get();
        $complaints = Complaint::where('user_id', '!=', $user)
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        foreach ($ownedComplaint as $data) {
            $data->uploaded_at = $data->updated_at->format('d M Y, H:i') . ' WIB';
        };

        foreach ($complaints as $complaint) {
            $complaint->uploaded_at = $complaint->updated_at->format('d M Y, H:i') . ' WIB';
        };

        return view('dashboard.complaint.complaints', compact('complaints', 'ownedComplaint'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.complaint.complaint-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'image_path.*' => 'mimes:png,jpg,jpeg,heic|max:5000',
            'captcha' => 'required|captcha',
        ]);
        // Geolocation QUERY
        $province = Provincy::where('id', $request->input('province'))->first();
        $regency = Regency::where('id', $request->input('regency'))->first();
        $district = District::where('id', $request->input('district'))->first();
        $village = Village::where('id', $request->input('village'))->first();

        $complaint = new Complaint();
        $complaint->title = $validatedData['title'];
        $complaint->description = $validatedData['description'];
        $complaint->user_id = Auth::id();
        $complaint->status = ComplaintStatus::BELUM_DIPROSES;
        $complaint->province = $province->name;
        $complaint->regency = $regency->name;
        $complaint->district = $district->name;
        $complaint->village = $village->name;
        $complaint->save();

        if ($request->hasFile('image_path')) {
            $counter = 1;

            foreach ($request->file('image_path') as $image) {
                $filename = 'gambar-' . Carbon::now()->timestamp . '-' . $counter . '.' . $image->getClientOriginalExtension();
                $image->storeAs('complaint_images', $filename, 'public');

                $complaintImage = new ComplaintImages();
                $complaintImage->complaint_id = $complaint->id;
                $complaintImage->image_path = $filename;
                $complaintImage->save();

                $counter++;
            };
        }

        return redirect()->route('complaints.index')->with('success', 'Aduan anda berhasil dikirim, tunggu respon dari petugas.');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $complaint = Complaint::where('slug', $slug)->firstOrFail();
        $complaint->uploaded_at = $complaint->updated_at->format('d M Y, H:i') . ' WIB';
        $statusOptions = [
            'Belum Diproses' => "Belum Diproses",
            'Sedang Diproses' => "Sedang Diproses",
            'Selesai' => "Selesai",
        ];

        // Complaint Images
        $complaintImages = ComplaintImages::where('complaint_id', $complaint->id)->get();
        $responses = Respon::where('complaint_id', $complaint->id)->get();

        return view('dashboard.complaint.complaint-detail', [
            'complaint' => $complaint,
            'complaintImages' => $complaintImages,
            'statusOptions' => $statusOptions,
            'responses' => $responses
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $complaint = Complaint::where('slug', $slug)->firstOrFail();
        return view('dashboard.complaint.complaint-edit', [
            'complaint' => $complaint,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:150',
            'description' => 'required|string',
            'image_path.*' => 'mimes:png,jpg,jpeg,heic|max:5000',
            'captcha' => 'required|captcha'
        ]);
        $complaint->update($validatedData);
        // Geolocation QUERY
        $province = Provincy::where('id', $request->input('province'))->first();
        $regency = Regency::where('id', $request->input('regency'))->first();
        $district = District::where('id', $request->input('district'))->first();
        $village = Village::where('id', $request->input('village'))->first();
        $complaint->province = $province->name;
        $complaint->regency = $regency->name;
        $complaint->district = $district->name;
        $complaint->village = $village->name;
        $complaint->save();
        if ($request->hasFile('image_path')) {
            // Old Images
            $oldImages = ComplaintImages::where('complaint_id', $complaint->id)->get();
            foreach ($oldImages as $oldImage) {
                // Delete old image from storage
                Storage::delete('public/complaint_images/' . $oldImage->image_path);
                // Delete old image entry from database
                $oldImage->delete();
            }

            $counter = 1;

            foreach ($request->file('image_path') as $image) {
                $filename = 'gambar-' . Carbon::now()->timestamp . '-' . $counter . '.' . $image->getClientOriginalExtension();
                $image->storeAs('complaint_images', $filename, 'public');

                $complaintImage = new ComplaintImages();
                $complaintImage->complaint_id = $complaint->id;
                $complaintImage->image_path = $filename;
                $complaintImage->save();

                $counter++;
            };
        }

        return redirect()->route('complaints.show', $complaint->slug)->with('success', 'Aduan anda berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {

        if ($complaint->images->count() > 0) {
            $complaintImages = ComplaintImages::where('complaint_id', $complaint->id)->get();
            foreach ($complaintImages as $index => $image) {
                Storage::disk('public')->delete('complaint_images/' . $image->image_path);
                $image->delete();
            }
        }

        $complaint->delete();
        return redirect()->route('complaints.index')->with('success', 'Aduan berhasil dihapus.');
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }

    public function getProv()
    {
        $data = Provincy::where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getRegencies($id)
    {
        $data = Regency::where('province_id', $id)->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getDistrict($id)
    {
        $data = District::where('regency_id', $id)->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function getVillage($id)
    {
        $data = Village::where('district_id', $id)->where('name', 'LIKE', '%' . request('q') . '%')->paginate(10);

        return response()->json($data);
    }

    public function complaintsSearch(Request $request)
    {
        $user = Auth::id();
        $query = $request->input('query');

        $ownedComplaint = Complaint::where('user_id', $user)->orderBy('created_at', 'desc')->get();

        foreach ($ownedComplaint as $data) {
            $data->uploaded_at = $data->updated_at->format('d M Y, H:i') . ' WIB';
        };

        $complaints = Complaint::where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('province', 'LIKE', '%' . $query . '%')
            ->orWhere('regency', 'LIKE', '%' . $query . '%')
            ->orWhere('district', 'LIKE', '%' . $query . '%')
            ->orWhere('village', 'LIKE', '%' . $query . '%')
            ->get();

        // Render hasil pencarian sebagai HTML menggunakan view partial (misalnya: _complaints.blade.php)
        $html = view('dashboard.complaint.partials._complaints', compact('complaints'))->render();

        return response()->json(['complaints' => $html]);
    }
}
