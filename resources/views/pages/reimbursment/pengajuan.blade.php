@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Pengajuan Reimbursment</h4>
                    <form action="{{ route('reimbursment.pengajuan') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class='form-group'>
                            <label for='kategori_id'>Kategori</label>
                            <select name='kategori_id' id='kategori_id'
                                class='form-control @error('kategori_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option @selected($category->id == old('kategori_id')) value='{{ $category->id }}'>{{ $category->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='deskripsi' class='mb-2'>Deskripsi</label>
                            <textarea name='deskripsi' id='deskripsi' cols='30' rows='3'
                                class='form-control @error('deskripsi') is-invalid @enderror'>{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
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
                        <div class='form-group mb-3'>
                            <label for='bukti' class='mb-2'>Bukti (PNG/JPG/JPEG)</label>
                            <input type='file' name='bukti' id='bukti'
                                class='form-control @error('bukti') is-invalid @enderror' value='{{ old('bukti') }}'>
                            @error('bukti')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='surat_jalan' class='mb-2'>Surat Jalan (PDF)</label>
                            <input type='file' name='surat_jalan' id='surat_jalan'
                                class='form-control @error('surat_jalan') is-invalid @enderror'
                                value='{{ old('surat_jalan') }}'>
                            @error('surat_jalan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal' class='mb-2'>Tanggal</label>
                            <input type='datetime-local' name='tanggal' id='tanggal'
                                class='form-control @error('tanggal') is-invalid @enderror' value='{{ old('tanggal') }}'>
                            @error('tanggal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
