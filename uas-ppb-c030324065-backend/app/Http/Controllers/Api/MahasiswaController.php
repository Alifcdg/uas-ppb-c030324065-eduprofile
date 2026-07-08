<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Http\Resources\MahasiswaResource;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $mahasiswa = Mahasiswa::with([
        'user',
        'programStudi',
        'angkatan',
        'hobby'
    ])
    ->when($search, function ($query) use ($search) {
        $query->where('nim', 'like', "%{$search}%")
              ->orWhereHas('user', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
              });
    })
    ->latest()
    ->paginate(10);

    return response()->json([
        'success' => true,
        'message' => 'Data mahasiswa berhasil diambil.',
        'data' => MahasiswaResource::collection($mahasiswa),
        'pagination' => [
            'current_page' => $mahasiswa->currentPage(),
            'last_page' => $mahasiswa->lastPage(),
            'per_page' => $mahasiswa->perPage(),
            'total' => $mahasiswa->total(),
        ]
    ]);
}

    public function store(StoreMahasiswaRequest $request)
    {
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->nim),
                'role' => 'Mahasiswa'
            ]);

            $fotoPath = null;

if ($request->hasFile('foto')) {
    $fotoPath = $request->file('foto')->store('mahasiswa', 'public');
}

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
                'foto' => $fotoPath,
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
    $mahasiswa->user->update([
        'name' => $request->nama,
        'email' => $request->email,
    ]);

    $fotoPath = $mahasiswa->foto;

if ($request->hasFile('foto')) {

    if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
        Storage::disk('public')->delete($mahasiswa->foto);
    }

    $fotoPath = $request->file('foto')->store('mahasiswa', 'public');
}

    $mahasiswa->update([
        'nim' => $request->nim,
        'program_studi_id' => $request->program_studi_id,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'angkatan_id' => $request->angkatan_id,
        'hobby_id' => $request->hobby_id,
        'foto' => $fotoPath,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Mahasiswa berhasil diperbarui.',
        'data' => new MahasiswaResource(
            $mahasiswa->load([
                'user',
                'programStudi',
                'angkatan',
                'hobby',
            ])
        ),
    ]);
}

    public function destroy(Mahasiswa $mahasiswa)
{
    DB::beginTransaction();

    try {

        $user = $mahasiswa->user;

        if ($mahasiswa->foto && Storage::disk('public')->exists($mahasiswa->foto)) {
    Storage::disk('public')->delete($mahasiswa->foto);
}

        $mahasiswa->delete();

        $user->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Mahasiswa berhasil dihapus.'
        ]);

    } catch (\Exception $e) {

        DB::rollBack();

        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);

    }
}
}
