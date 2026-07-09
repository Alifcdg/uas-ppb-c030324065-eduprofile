@extends('layouts.app')

@section('page-title', 'Tambah Mahasiswa')

@section('content-body')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Tambah Mahasiswa</h3>
    </div>

    <form
        action="{{ route('admin.mahasiswa.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>NIM</label>
                        <input
                            type="text"
                            name="nim"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Tanggal Lahir</label>
                        <input
                            type="date"
                            name="tanggal_lahir"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Jenis Kelamin</label>

                        <select
                            name="jenis_kelamin"
                            class="form-control">

                            <option value="Laki-laki">
                                Laki-laki
                            </option>

                            <option value="Perempuan">
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

                                <option value="{{ $item->id }}">
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

                                <option value="{{ $item->id }}">
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

                                <option value="{{ $item->id }}">
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
                            class="form-control"></textarea>

                    </div>

                    <div class="mb-3">

                        <label>No HP</label>

                        <input
                            type="text"
                            name="no_hp"
                            class="form-control">

                    </div>

                    <div class="mb-3">

                        <label>Foto</label>

                        <input
                            type="file"
                            name="foto"
                            class="form-control">

                    </div>

                </div>

            </div>

        </div>

        <div class="card-footer">

            <button
                class="btn btn-primary">

                Simpan

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
