@extends('layouts.app')

@section('page-title','Dashboard Mahasiswa')

@section('content-body')

<div class="row">

    <div class="col-md-12">

        <div class="card">

            <div class="card-body text-center">

                <h3>
                    Selamat Datang
                </h3>

                <h4>

                    {{ auth()->user()->name }}

                </h4>

                <br>

                <a
                    href="{{ route('mahasiswa.profile') }}"
                    class="btn btn-primary">

                    Lihat Profile

                </a>

            </div>

        </div>

    </div>

</div>

@stop
