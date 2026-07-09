<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\Angkatan;
use App\Models\Hobby;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
{
    return view('admin.mahasiswa.create', [
        'prodi' => ProgramStudi::all(),
        'angkatan' => Angkatan::all(),
        'hobby' => Hobby::all(),
    ]);
}

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users,email',
        'nim' => 'required|unique:mahasiswas,nim',
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required',
        'program_studi_id' => 'required',
        'angkatan_id' => 'required',
        'hobby_id' => 'required',
    ]);

    $user = User::create([
        'name' => $request->nama,
        'email' => $request->email,
        'password' => Hash::make('12345678'),
        'role' => 'Mahasiswa',
    ]);

    $foto = null;

    if ($request->hasFile('foto')) {
        $foto = $request->file('foto')->store('mahasiswa', 'public');
    }

    Mahasiswa::create([
        'user_id' => $user->id,
        'nim' => $request->nim,
        'program_studi_id' => $request->program_studi_id,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'no_hp' => $request->no_hp,
        'angkatan_id' => $request->angkatan_id,
        'hobby_id' => $request->hobby_id,
        'foto' => $foto,
    ]);

    return redirect()
        ->route('admin.mahasiswa.index')
        ->with('success', 'Mahasiswa berhasil ditambahkan');
}

    public function show(Mahasiswa $mahasiswa)
{
    $mahasiswa->load([
        'user',
        'programStudi',
        'angkatan',
        'hobby',
    ]);

    return view(
        'admin.mahasiswa.show',
        compact('mahasiswa')
    );
}

    public function edit(Mahasiswa $mahasiswa)
{
    $mahasiswa->load([
        'user',
        'programStudi',
        'angkatan',
        'hobby',
    ]);

    return view('admin.mahasiswa.edit', [
        'mahasiswa' => $mahasiswa,
        'prodi' => ProgramStudi::all(),
        'angkatan' => Angkatan::all(),
        'hobby' => Hobby::all(),
    ]);
}

    public function update(Request $request, Mahasiswa $mahasiswa)
{
    $request->validate([
        'nama' => 'required',
        'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
        'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
        'tanggal_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'alamat' => 'required',
        'no_hp' => 'required',
        'program_studi_id' => 'required',
        'angkatan_id' => 'required',
        'hobby_id' => 'required',
    ]);

    $mahasiswa->user->update([
        'name' => $request->nama,
        'email' => $request->email,
    ]);

    if ($request->hasFile('foto')) {

        $foto = $request->file('foto')
            ->store('mahasiswa', 'public');

        $mahasiswa->foto = $foto;
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
        'foto' => $mahasiswa->foto,
    ]);

    return redirect()
        ->route('admin.mahasiswa.index')
        ->with('success', 'Mahasiswa berhasil diupdate');
}

    public function destroy(Mahasiswa $mahasiswa)
{
    if ($mahasiswa->foto) {
        Storage::disk('public')->delete($mahasiswa->foto);
    }

    $user = $mahasiswa->user;

    $mahasiswa->delete();

    $user->delete();

    return redirect()
        ->route('admin.mahasiswa.index')
        ->with('success', 'Mahasiswa berhasil dihapus');
}
}
