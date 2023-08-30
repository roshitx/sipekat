<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('dashboard.user.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        // Define the $selectOptions variable here
        $genderOptions = [
            'pria' => 'Pria',
            'wanita' => 'Wanita',
            'lainnya' => 'Lainnya',
            // Add more options as needed
        ];

        $roleOptions = [
            'admin' => 'Admin',
            'petugas' => 'Petugas',
            'masyarakat' => 'Masyarakat',
        ];

        return view('dashboard.user.user-create', compact('genderOptions', 'roleOptions', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'role' => 'required',
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'string|max:255'
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $data = User::create($validatedData);
        // Store the image in the public/storage directory
        if ($request->hasFile('avatar')) {
            $image = $request->file('avatar');
            $filename = 'avatar-' . Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
            $image->storeAs('avatar', $filename, 'public');
            $data->avatar = $filename;
            $data->save();
        }

        return redirect()->route('users')->with('success', 'Berhasil membuat user baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $genderOptions = [
            'pria' => 'Pria',
            'wanita' => 'Wanita',
            'lainnya' => 'Lainnya',
            // Add more options as needed
        ];

        return view('profile.edit', [
            'user' => $user,
            'genderOptions' => $genderOptions,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $genderOptions = [
            'pria' => 'Pria',
            'wanita' => 'Wanita',
            'lainnya' => 'Lainnya',
            // Add more options as needed
        ];

        $roleOptions = [
            'admin' => 'Admin',
            'petugas' => 'Petugas',
            'masyarakat' => 'Masyarakat',
        ];

        return view('dashboard.user.user-edit', compact('genderOptions', 'roleOptions', 'user'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, User $user)
    {
        $req->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'string|max:255'
        ]);
        $data = $req->except('_token');
        if ($req->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user->password;
        }

        $user->update($data);
        // Store the image in the public/storage directory
        if ($req->hasFile('avatar')) {
            if ($user->avatar) {
                // Delete old avatar if exists
                Storage::disk('public')->delete('avatar/' . $user->avatar);
            }

            $image = $req->file('avatar');
            $filename = Carbon::now()->timestamp . '.' . $image->getClientOriginalExtension();
            $image->storeAs('avatar', $filename, 'public');
            $user->avatar = $filename;
            $user->save($data);
        }
        return redirect()->route('users')->with('success', 'Berhasil mengubah data user.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->avatar) {
            Storage::disk('public')->delete('avatar/' . $user->avatar);
        }

        $user->delete();
        return redirect()->route('users')->with('success', "User $user->name berhasil di hapus.");
    }

    public function export()
    {
        $users = User::orderBy('name')->get();
        $options = new Options();
        $options->set('defaultFont', 'Courier');
        $data = [
            'title' => 'Data user website SiPekat',
            'description' => 'Sistem Pengaduan Masyarakat',
            'date' => date('d M Y'),
            'users' => $users
        ];
        $pdf = PDF::loadView('dashboard.user.export-users', $data);
        return $pdf->download('users.pdf');
    }
}
