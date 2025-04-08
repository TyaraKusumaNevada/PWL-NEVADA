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


    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048', 
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika sudah ada foto lama, bisa dihapus atau di-overwrite
        // if ($user->foto) {
        //     Storage::delete('public/uploads/'.$user->foto);
        // }

        // Simpan file ke folder 'public/uploads' (dalam storage)
        // Nanti boleh gunakan "php artisan storage:link" supaya folder public/storage -> storage/app/public
        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/uploads', $fileName);

        // Update path foto di database
        $user->foto = $fileName;
        $user->save();

        // Response untuk Ajax
        return response()->json([
            'status' => 'success',
            'message' => 'Foto profil berhasil diperbarui!',
            'foto_path' => asset('storage/uploads/' . $fileName)
        ]);
    }
}
