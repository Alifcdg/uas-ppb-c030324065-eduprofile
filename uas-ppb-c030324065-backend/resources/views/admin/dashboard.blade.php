@extends('layouts.app')

@section('page-title', 'Dashboard Admin')

@section('content-body')

<div class="row">

    <div class="col-lg-4">

        <x-adminlte-small-box
            title="Mahasiswa"
            text="Kelola Data Mahasiswa"
            icon="fas fa-user-graduate"
            theme="primary"
            url="{{ route('admin.mahasiswa.index') }}"
            url-text="Lihat Data"
        />

    </div>

</div>

@stop
