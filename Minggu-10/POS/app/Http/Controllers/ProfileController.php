<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Jika nama model Anda berbeda, sesuaikan
use Illuminate\Support\Facades\Storage; //pastikan ada

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil data user yang sedang login (kalau pakai Auth)
        $user = Auth::user();
        $breadcrumb = (object) [
            'title' => 'Profil Saya',
            'list' => ['Home', 'Profil']
        ];

        $activeMenu = 'profile';
     
        // Return view 'profile' dengan data user
        return view('profile', compact('user', 'breadcrumb', 'activeMenu'));


    }


    public function editProfileAjax()
    {
        // Kembalikan view modal untuk mengubah foto profil
        return view('profile_edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        if ($request->hasFile('foto')) {
            if ($user->foto && Storage::disk('public')->exists('foto/' . $user->foto)) {
                Storage::disk('public')->delete('foto/' . $user->foto);
            }
    
            $file = $request->file('foto');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto', $filename, 'public');
            $user->foto = $filename;
        }
    
        $user->save();
    
        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Foto profil berhasil diperbarui.',
                'foto_path' => asset('storage/foto/' . $user->foto),
            ]);
        }
    
        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }    

}
