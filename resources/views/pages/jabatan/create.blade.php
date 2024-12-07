@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Jabatan</h4>
                    <form action="{{ route('jabatan.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksimal_anggaran_perbulan' class='mb-2'>Maksimal Anggaran/Bulan</label>
                            <input type='number' name='maksimal_anggaran_perbulan' id='maksimal_anggaran_perbulan'
                                class='form-control @error('maksimal_anggaran_perbulan') is-invalid @enderror'
                                value='{{ old('maksimal_anggaran_perbulan') }}'>
                            @error('maksimal_anggaran_perbulan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('jabatan.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Jabatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
