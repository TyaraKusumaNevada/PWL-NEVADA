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

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika sudah ada foto lama, hapus dari disk 'public/uploads'
        if ($user->foto) {
            Storage::disk('public')->delete('uploads/' . $user->foto);
        }

        // Proses simpan file ke folder 'public/uploads'
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/uploads', $fileName);

        // Simpan path foto ke database (pastikan kolomnya sesuai, misalnya 'foto')
        $user->foto = $fileName;
        $user->save();

        return response()->json([
            'status'    => 'success',
            'message'   => 'Foto profil berhasil diperbarui!',
            'foto_path' => asset('storage/uploads/' . $fileName)
        ]);
    }

}
