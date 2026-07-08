<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'programStudi',
            'angkatan',
            'hobby'
        ])->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data mahasiswa berhasil diambil.',
            'data' => MahasiswaResource::collection($mahasiswa)
        ]);
    }

    public function store(StoreMahasiswaRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->nim),
                'role' => 'Mahasiswa'
            ]);

            $mahasiswa = Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->nim,
                'program_studi_id' => $request->program_studi_id,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'angkatan_id' => $request->angkatan_id,
                'hobby_id' => $request->hobby_id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa berhasil ditambahkan.',
                'data' => new MahasiswaResource(
                    $mahasiswa->load('user', 'programStudi', 'angkatan', 'hobby')
                )
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('user', 'programStudi', 'angkatan', 'hobby');

        return response()->json([
            'success' => true,
            'data' => new MahasiswaResource($mahasiswa)
        ]);
    }

    public function update(UpdateMahasiswaRequest $request, Mahasiswa $mahasiswa)
    {
        //
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        //
    }
}
