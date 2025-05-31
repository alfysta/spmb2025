<?php

namespace App\Http\Controllers\Pendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Siswa\Pendaftaran;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiswaController extends Controller
{
    public function index()
    {
        return Inertia::render('pendaftaran/Index', [
            'user' => auth()->user(),
            'student' => Pendaftaran::where('user_id', auth()->user()->id)->get(),
        ]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'jenis_kelamin' => 'required',
            'jenjang_pendidikan' => 'required',
            'asal_sekolah' => 'required',
            'tahun_lulus' => 'required',
            'no_hp' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'desa' => 'required',
            'kode_pos' => 'required',
        ]);

        $student = Pendaftaran::where('user_id', auth()->user()->id)->first();

        if ($request->file('foto')) {

            $folder = "/images/" . auth()->user()->nisn;
            $fileName = str()->uuid() . "." . $request->file('foto')->getClientOriginalExtension();

            $images = $request->file('foto')->storeAs($folder, $fileName, 'public');
        } else {
            $images = $student->foto;
        }

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
            'foto' => $images
        ]);

        $student->update($data);


        return to_route('pendaftaran.show');
    }

    public function show()
    {
        return Inertia::render('pendaftaran/Berkas', [
            'user' => auth()->user(),
            'student' => Pendaftaran::where('user_id', auth()->user()->id)->get(),
        ]);
    }

    public function updateBerkas(Request $request)
    {
        $folder = "/images/" . auth()->user()->nisn;
        $fileName = str()->uuid() . "." . $request->file('kartu_keluarga')->getClientOriginalExtension();

        $kartuKeluarga = $request->file('kartu_keluarga')->storeAs($folder, $fileName, 'public');
    }
}
