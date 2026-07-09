@extends('layouts.app')

@section('page-title', 'Data Mahasiswa')

@section('content-body')

<div class="card">

    <div class="card-header d-flex justify-content-between">

        <h3 class="card-title">
            Daftar Mahasiswa
        </h3>

        <a href="{{ route('admin.mahasiswa.create') }}"
           class="btn btn-primary">

            + Tambah Mahasiswa

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Program Studi</th>
                    <th>Angkatan</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($mahasiswa as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->user->name }}</td>

                    <td>{{ $item->nim }}</td>

                    <td>{{ $item->programStudi->nama_program_studi }}</td>

                    <td>{{ $item->angkatan->tahun }}</td>

                    <td>

    <a
        href="{{ route('admin.mahasiswa.show',$item->id) }}"
        class="btn btn-info btn-sm">

        Detail

    </a>

    <a
        href="{{ route('admin.mahasiswa.edit',$item->id) }}"
        class="btn btn-warning btn-sm">

        Edit

    </a>

    <form
        action="{{ route('admin.mahasiswa.destroy',$item->id) }}"
        method="POST"
        style="display:inline;">

        @csrf
        @method('DELETE')

        <button
            class="btn btn-danger btn-sm"
            onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')">

            Hapus

        </button>

    </form>

</td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">

                        Belum ada data mahasiswa.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@stop
