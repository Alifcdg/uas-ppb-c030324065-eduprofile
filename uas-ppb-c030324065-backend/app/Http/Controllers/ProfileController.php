<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'programStudi',
            'angkatan',
            'hobby',
        ])->where('user_id', Auth::id())->first();

        return view('mahasiswa.profile', compact('mahasiswa'));
    }

    public function edit()
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'programStudi',
            'angkatan',
            'hobby',
        ])->where('user_id', Auth::id())->first();

        return view(
            'mahasiswa.edit-profile',
            compact('mahasiswa')
        );
    }

    public function update(Request $request)
    {
        $mahasiswa = Mahasiswa::where(
            'user_id',
            Auth::id()
        )->first();

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        $mahasiswa->user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);
                if ($request->hasFile('foto')) {

            if ($mahasiswa->foto) {

                Storage::disk('public')->delete(
                    $mahasiswa->foto
                );

            }

            $mahasiswa->foto = $request
                ->file('foto')
                ->store('mahasiswa', 'public');
        }

        $mahasiswa->update([
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'foto' => $mahasiswa->foto,
        ]);

        return redirect()
            ->route('mahasiswa.profile')
            ->with(
                'success',
                'Profile berhasil diupdate'
            );
    }
}
