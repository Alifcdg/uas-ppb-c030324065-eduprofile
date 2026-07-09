<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'programStudi',
            'angkatan',
            'hobby'
        ])
        ->where('user_id', $request->user()->id)
        ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new MahasiswaResource($mahasiswa),
        ]);
    }

    public function update(Request $request)
    {
        $mahasiswa = Mahasiswa::where(
            'user_id',
            $request->user()->id
        )->firstOrFail();

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'no_hp' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        $mahasiswa->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        $foto = $mahasiswa->foto;

        if ($request->hasFile('foto')) {

            if ($foto && Storage::disk('public')->exists($foto)) {
                Storage::disk('public')->delete($foto);
            }

            $foto = $request
                ->file('foto')
                ->store('mahasiswa', 'public');
        }

        $mahasiswa->update([
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'foto' => $foto,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => new MahasiswaResource(
                $mahasiswa->load([
                    'user',
                    'programStudi',
                    'angkatan',
                    'hobby'
                ])
            ),
        ]);
    }
}
