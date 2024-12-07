@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Laporan Reimbursment</h4>
                    <form action="{{ route('laporan.reimbursment.print') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md">
                                <div class='form-group mb-3'>
                                    <label for='tanggal_awal' class='mb-2'>Tanggal Mulai</label>
                                    <input type='date' name='tanggal_awal' id='tanggal_awal'
                                        class='form-control form-control-sm @error('tanggal_awal') is-invalid @enderror'
                                        value='{{ old('tanggal_awal') }}'>
                                    @error('tanggal_awal')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class='form-group mb-3'>
                                    <label for='tanggal_akhir' class='mb-2'>Tanggal Akhir</label>
                                    <input type='date' name='tanggal_akhir' id='tanggal_akhir'
                                        class='form-control form-control-sm @error('tanggal_akhir') is-invalid @enderror'
                                        value='{{ old('tanggal_akhir') }}'>
                                    @error('tanggal_akhir')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md">
                                <div class='form-group'>
                                    <label for='status'>Status</label>
                                    <select name='status' id='status'
                                        class='form-control @error('status') is-invalid @enderror' style="padding:12px">
                                        <option value='all' selected>Pilih status</option>
                                        <option value="0">Menunggu Persetujuan</option>
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                    @error('status')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md align-self-end">
                                <div class="form-group">
                                    <button class="btn btn-danger mt-3 pt-3">Export PDF</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Datatable />
