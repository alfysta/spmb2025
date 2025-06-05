<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use App\Models\Siswa\Berkas;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class SiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return Inertia::render('pendaftaran/Index', [
            'user' => $user,
            'student' => Pendaftaran::where('user_id', $user->id)->get(),
        ]);
    }
    public function getProvinces()
    {
        $response = Http::get('https://wilayah.id/api/provinces.json');
        return $response->json();
    }

    public function getRegencies($code)
    {
        $response = Http::get("https://wilayah.id/api/regencies/{$code}.json");
        return $response->json();
    }

    public function getDistricts($code)
    {
        $response = Http::get("https://wilayah.id/api/districts/{$code}.json");
        return $response->json();
    }

    public function getVillages($code)
    {
        $response = Http::get("https://wilayah.id/api/villages/{$code}.json");
        return $response->json();
    }




    public function update(Request $request)
    {
        // $request->validate([
        //     'jenis_kelamin' => 'required',
        //     'jenjang_pendidikan' => 'required',
        //     'asal_sekolah' => 'required',
        //     'tahun_lulus' => 'required',
        //     'no_hp' => 'required',
        //     'provinsi' => 'required',
        //     'kabupaten' => 'required',
        //     'kecamatan' => 'required',
        //     'desa' => 'required',
        //     'kode_pos' => 'required',
        // ]);

        $student = Pendaftaran::where('user_id', auth()->user()->id)->first();
        $data = ([
            'jenis_kelamin' => $request->jenis_kelamin,
            'jenjang_pendidikan' => $request->jenjang_pendidikan,
            'asal_sekolah' => $request->asal_sekolah,
            'tahun_lulus' => $request->tahun_lulus,
            'no_hp' => $request->no_hp,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'kode_pos' => $request->kode_pos,
        ]);

        $student->update($data);
        return to_route('pendaftaran.show');
    }

    public function show()
    {

        return Inertia::render('pendaftaran/Berkas', [
            'user' => auth()->user(),
            'student' => Pendaftaran::where('user_id', auth()->user()->id)->get(),
            'berkas' => Berkas::where('user_id', auth()->user()->id)->get(),
        ]);
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'image' => 'required|max:5048',
        ]);

        $user = Auth::user();

        // Hapus gambar lama jika ada
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        // Simpan gambar baru
        $path = $request->file('image')->store("images/{$user->nisn}", 'public');

        $user->image = $path;
        $user->save();

        return response()->json([
            'message' => 'Foto profil berhasil diupload.',
            'image_url' => asset("storage/$path"),
        ]);
    }
    public function updateBerkas(Request $request)
    {
        $berkas = Berkas::where('user_id', auth()->user()->id)->first();
        $request->validate([
            'type' => 'required|in:kartu_keluarga,ijazah,akte_kelahiran,ktp_ortu,sptjm,rapor',
            'file' => 'required|mimes:pdf|max:5120',
        ]);

        $user = Auth::user();
        $type = $request->type;

        if ($berkas->$type) {
            Storage::disk('public')->delete($berkas->$type);
        }

        $path = $request->file('file')->store("images/{$user->nisn}", 'public');

        $berkas->$type = $path;
        $berkas->save();

        return response()->json([
            'message' => ucfirst(str_replace('_', ' ', $type)) . ' berhasil diupload.',
            'url' => asset("storage/{$path}")
        ]);
    }
}
