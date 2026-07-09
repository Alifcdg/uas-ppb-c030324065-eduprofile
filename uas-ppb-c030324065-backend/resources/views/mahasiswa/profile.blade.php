@extends('layouts.app')

@section('page-title', 'Profile Mahasiswa')

@section('content-body')

<div class="row">

    <div class="col-md-4">

        <div class="card">

            <div class="card-body text-center">

                @if($mahasiswa->foto)

                    <img
                        src="{{ asset('storage/'.$mahasiswa->foto) }}"
                        class="rounded-circle mb-3"
                        width="170"
                        height="170"
                        style="object-fit:cover;">

                @else

                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->user->name) }}&size=200"
                        class="rounded-circle mb-3">

                @endif

                <h3>{{ $mahasiswa->user->name }}</h3>

                <p class="text-muted">
                    {{ $mahasiswa->user->email }}
                </p>

                <a
                    href="{{ route('mahasiswa.profile.edit') }}"
                    class="btn btn-warning">

                    Edit Profile

                </a>

            </div>

        </div>

    </div>

    <div class="col-md-8">

        <div class="card">

            <div class="card-header">

                <h4>Informasi Mahasiswa</h4>

            </div>

            <div class="card-body">

                <table class="table table-bordered">

                    <tr>
                        <th width="220">NIM</th>
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

            </div>

        </div>

    </div>

</div>

@stop
