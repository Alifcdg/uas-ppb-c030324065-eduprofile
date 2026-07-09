@extends('layouts.app')

@section('page-title', 'Edit Profile')

@section('content-body')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Edit Profile</h3>
    </div>

    <form
        action="{{ route('mahasiswa.profile.update') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 text-center">

                    @if($mahasiswa->foto)

                        <img
                            src="{{ asset('storage/'.$mahasiswa->foto) }}"
                            width="180"
                            height="180"
                            class="rounded-circle img-thumbnail"
                            style="object-fit:cover;">

                    @else

                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($mahasiswa->user->name) }}&size=200"
                            class="rounded-circle img-thumbnail">

                    @endif

                    <br><br>

                    <input
                        type="file"
                        name="foto"
                        class="form-control">

                </div>

                <div class="col-md-8">

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

                        <label>Alamat</label>

                        <textarea
                            name="alamat"
                            rows="4"
                            class="form-control"
                            required>{{ $mahasiswa->alamat }}</textarea>

                    </div>

                    <div class="mb-3">

                        <label>No HP</label>

                        <input
                            type="text"
                            name="no_hp"
                            class="form-control"
                            value="{{ $mahasiswa->no_hp }}"
                            required>

                    </div>
                                    </div>

            </div>

        </div>

        <div class="card-footer">

            <button
                type="submit"
                class="btn btn-primary">

                Simpan Perubahan

            </button>

            <a
                href="{{ route('mahasiswa.profile') }}"
                class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>

@stop
