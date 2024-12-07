@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Anggaran</h4>
                    <form action="{{ route('anggaran.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='department' class='mb-2'>Department</label>
                            <input type='text' name='department' id='department'
                                class='form-control @error('department') is-invalid @enderror'
                                value='{{ $item->department->nama ?? old('department') }}' disabled>
                            @error('department')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='bulan' class='mb-2'>Bulan</label>
                            <input type='text' name='bulan' id='bulan'
                                class='form-control @error('bulan') is-invalid @enderror'
                                value='{{ getMonthName($item->bulan) ?? old('bulan') }}' disabled>
                            @error('bulan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tahun' class='mb-2'>Tahun</label>
                            <input type='number' name='tahun' id='tahun'
                                class='form-control @error('tahun') is-invalid @enderror'
                                value='{{ $item->tahun ?? old('tahun') }}' disabled>
                            @error('tahun')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror'
                                value='{{ $item->nominal ?? old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('anggaran.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Anggaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
