@extends('layouts.app')

@section('page-title', 'Edit Mahasiswa')

@section('content-body')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Edit Mahasiswa</h3>
    </div>

    <form
        action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="mb-3">
                        <label>Nama</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            value="{{ $mahasiswa->user->name }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Email</label>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ $mahasiswa->user->email }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>NIM</label>

                        <input
                            type="text"
                            name="nim"
                            class="form-control"
                            value="{{ $mahasiswa->nim }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Tanggal Lahir</label>

                        <input
                            type="date"
                            name="tanggal_lahir"
                            class="form-control"
                            value="{{ $mahasiswa->tanggal_lahir }}"
                            required>

                    </div>

                    <div class="mb-3">

                        <label>Jenis Kelamin</label>

                        <select
                            name="jenis_kelamin"
                            class="form-control">

                            <option
                                value="Laki-laki"
                                {{ $mahasiswa->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>
                                Laki-laki
                            </option>

                            <option
                                value="Perempuan"
                                {{ $mahasiswa->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>
                                Perempuan
                            </option>

                        </select>

                    </div>

                </div>

                <div class="col-md-6">
                                        <div class="mb-3">

                        <label>Program Studi</label>

                        <select
                            name="program_studi_id"
                            class="form-control">

                            @foreach($prodi as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ $item->id == $mahasiswa->program_studi_id ? 'selected' : '' }}>

                                    {{ $item->nama_program_studi }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Angkatan</label>

                        <select
                            name="angkatan_id"
                            class="form-control">

                            @foreach($angkatan as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ $item->id == $mahasiswa->angkatan_id ? 'selected' : '' }}>

                                    {{ $item->tahun }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Hobby</label>

                        <select
                            name="hobby_id"
                            class="form-control">

                            @foreach($hobby as $item)

                                <option
                                    value="{{ $item->id }}"
                                    {{ $item->id == $mahasiswa->hobby_id ? 'selected' : '' }}>

                                    {{ $item->nama_hobby }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="mb-3">

                        <label>Alamat</label>

                        <textarea
                            name="alamat"
                            rows="3"
                            class="form-control">{{ $mahasiswa->alamat }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label>No HP</label>

                        <input
                            type="text"
                            name="no_hp"
                            class="form-control"
                            value="{{ $mahasiswa->no_hp }}">

                    </div>

                    <div class="mb-3">

                        <label>Foto</label>

                        @if($mahasiswa->foto)

                            <div class="mb-2">

                                <img
                                    src="{{ asset('storage/'.$mahasiswa->foto) }}"
                                    width="120"
                                    class="img-thumbnail">

                            </div>

                        @endif

                        <input
                            type="file"
                            name="foto"
                            class="form-control">

                        <small class="text-muted">
                            Kosongkan jika tidak ingin mengganti foto.
                        </small>

                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <button
                type="submit"
                class="btn btn-warning">

                Update Mahasiswa

            </button>

            <a
                href="{{ route('admin.mahasiswa.index') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>

@stop
