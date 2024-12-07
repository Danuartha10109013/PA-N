@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Anggaran</h4>
                    <form action="{{ route('anggaran.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='department_id'>Department</label>
                            <select name='department_id' id='department_id'
                                class='form-control @error('department_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Department</option>
                                @foreach ($departments as $department)
                                    <option @selected($department->id == old('department_id')) value='{{ $department->id }}'>
                                        {{ $department->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='bulan'>Bulan</label>
                            <select name='bulan' id='bulan' class='form-control @error('bulan') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih bulan</option>
                                @foreach ($months as $month)
                                    <option @selected($month['number'] == old('bulan')) value='{{ $month['number'] }}'>{{ $month['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bulan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tahun' class='mb-2'>Tahun</label>
                            <input type='number' name='tahun' id='tahun'
                                class='form-control @error('tahun') is-invalid @enderror' value='{{ old('tahun') }}'>
                            @error('tahun')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nominal' class='mb-2'>Nominal</label>
                            <input type='number' name='nominal' id='nominal'
                                class='form-control @error('nominal') is-invalid @enderror' value='{{ old('nominal') }}'>
                            @error('nominal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('anggaran.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Anggaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
