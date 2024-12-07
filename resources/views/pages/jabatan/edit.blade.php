@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Jabatan</h4>
                    <form action="{{ route('jabatan.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ $item->nama ?? old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='maksimal_anggaran_perbulan' class='mb-2'>Maksimal Anggaran/Bulan</label>
                            <input type='text' name='maksimal_anggaran_perbulan' id='maksimal_anggaran_perbulan'
                                class='form-control @error('maksimal_anggaran_perbulan') is-invalid @enderror'
                                value='{{ $item->maksimal_anggaran_bulan ?? old('maksimal_anggaran_perbulan') }}'>
                            @error('maksimal_anggaran_perbulan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('jabatan.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Jabatan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
