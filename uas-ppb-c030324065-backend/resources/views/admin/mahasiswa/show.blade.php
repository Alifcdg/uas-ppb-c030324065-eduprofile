@extends('layouts.app')

@section('page-title', 'Detail Mahasiswa')

@section('content-body')

<div class="card">

    <div class="card-header">

        <h3 class="card-title">
            Detail Mahasiswa
        </h3>

    </div>

    <div class="card-body">

        <div class="text-center mb-4">

            @if($mahasiswa->foto)

                <img
                    src="{{ asset('storage/'.$mahasiswa->foto) }}"
                    width="150"
                    class="rounded-circle">

            @else

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->user->name) }}"
                    width="150"
                    class="rounded-circle">

            @endif

        </div>

        <table class="table table-bordered">

            <tr>
                <th width="220">Nama</th>
                <td>{{ $mahasiswa->user->name }}</td>
            </tr>

            <tr>
                <th>Email</th>
                <td>{{ $mahasiswa->user->email }}</td>
            </tr>

            <tr>
                <th>NIM</th>
                <td>{{ $mahasiswa->nim }}</td>
            </tr>

            <tr>
                <th>Program Studi</th>
                <td>{{ $mahasiswa->programStudi->nama_program_studi }}</td>
            </tr>

            <tr>
                <th>Angkatan</th>
                <td>{{ $mahasiswa->angkatan->tahun }}</td>
            </tr>

            <tr>
                <th>Hobby</th>
                <td>{{ $mahasiswa->hobby->nama_hobby }}</td>
            </tr>

            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ $mahasiswa->tanggal_lahir }}</td>
            </tr>

            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $mahasiswa->jenis_kelamin }}</td>
            </tr>

            <tr>
                <th>Alamat</th>
                <td>{{ $mahasiswa->alamat }}</td>
            </tr>

            <tr>
                <th>No HP</th>
                <td>{{ $mahasiswa->no_hp }}</td>
            </tr>

        </table>

        <a
            href="{{ route('admin.mahasiswa.index') }}"
            class="btn btn-secondary">

            Kembali

        </a>

    </div>

</div>

@stop
