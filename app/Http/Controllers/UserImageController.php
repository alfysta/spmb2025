<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserImageController extends Controller
{
    public function index()
    {
        return Inertia::render('pendaftaran/Berkas');
    }
    public function update(Request $request)
    {
        $request->validate([
            'image' => 'required|max:2048',
        ]);

        $user = Auth::user();

        // Hapus gambar lama jika ada
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // Simpan gambar baru
        $path = $request->file('image')->store("images/{$user->nisn}", 'public');

        $user->profile_image = $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diupload.',
            'image_url' => asset("storage/$path"),
        ]);
    }
}
