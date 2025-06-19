@extends('layouts.app')
@section('content')
    @if (!$item->pembayaran && role_staff_keuangan())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    <strong>Perhatian!</strong>
                    <p>Mohon maaf, {{ $item->user->name ?? '-' }} belum mengisi metode pembayaran. <br>
                        Silahkan hubungi staff yang bersangkutan untuk mengisi metode pembayaran.</p>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-5">Atur Pembayaran</h4>
                        <form action="{{ route('reimbursment.proses-pembayaran', $item->id) }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            @method('patch')
                            <div class="form-group mb-3">
                            <label for="metode_pembayaran" class="mb-2">Metode Pembayaran</label>

                            <select name="metode_pembayaran" id="metode_pembayaran"
                                class="form-control @error('metode_pembayaran') is-invalid @enderror"
                                {{ role_staff_keuangan() ? 'disabled' : '' }}>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Tunai" 
                                    {{ (old('metode_pembayaran', $item->pembayaran->metode_pembayaran ?? '') == 'Tunai') ? 'selected' : '' }}>
                                    Tunai
                                </option>
                                <option value="Transfer" 
                                    {{ (old('metode_pembayaran', $item->pembayaran->metode_pembayaran ?? '') == 'Transfer') ? 'selected' : '' }}>
                                    Transfer
                                </option>
                            </select>

                            @if (role_staff_keuangan())
                                {{-- Hidden input to preserve value --}}
                                <input type="hidden" name="metode_pembayaran"
                                    value="{{ old('metode_pembayaran', $item->pembayaran->metode_pembayaran ?? '') }}">
                            @endif

                            @error('metode_pembayaran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                            {{-- Nomor Rekening --}}
                            <div class='form-group mb-3 transfer-field' id="nomorRekeningGroup" style="display: none;">
                                <label for='nomor_rekening' class='mb-2'>Nomor Rekening</label>
                                <input type='text' name='nomor_rekening' id='nomor_rekening'
                                    class='form-control @error('nomor_rekening') is-invalid @enderror'
                                    value='{{ $item->pembayaran->nomor_rekening ?? old('nomor_rekening') }}'
                                    @readonly(role_staff_keuangan())>
                                @error('nomor_rekening')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nama Rekening --}}
                            <div class="form-group mb-3 transfer-field" id="namaRekeningGroup" style="display: none;">
                                <label for="nama_rekening" class="mb-2">Nama Rekening</label>
                                <input type="text" name="nama_rekening" id="nama_rekening"
                                    class="form-control @error('nama_rekening') is-invalid @enderror"
                                    value="{{ $item->pembayaran->nama_rekening ?? old('nama_rekening') }}"
                                    {{ role_staff_keuangan() ? 'readonly' : '' }}>
                                @error('nama_rekening')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pemilik --}}
                            <div class='form-group mb-3 transfer-field' id="pemilikGroup" style="display: none;">
                                <label for='pemilik' class='mb-2'>Pemilik</label>
                                <input type='text' name='pemilik' id='pemilik'
                                    class='form-control @error('pemilik') is-invalid @enderror'
                                    value='{{ $item->pembayaran->pemilik ?? old('pemilik') }}'
                                    @readonly(role_staff_keuangan())>
                                @error('pemilik')
                                    <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Script --}}
                            <script>
                                function toggleTransferFields() {
                                    const metode = document.getElementById('metode_pembayaran').value;
                                    const fields = document.querySelectorAll('.transfer-field');

                                    fields.forEach(field => {
                                        field.style.display = (metode === 'Transfer') ? 'block' : 'none';
                                    });
                                }

                                document.addEventListener('DOMContentLoaded', function () {
                                    toggleTransferFields(); // Initial display
                                    const select = document.getElementById('metode_pembayaran');
                                    if (select && !select.hasAttribute('readonly') && !select.disabled) {
                                        select.addEventListener('change', toggleTransferFields);
                                    }
                                });
                            </script>

                            @if (role_staff_keuangan())
                                    <input type="hidden" name="status_pembayaran" value="Lunas">
                                <div class='form-group mb-3'>
                                    <label for='tanggal_pembayaran' class='mb-2'>Tanggal Pembayaran</label>
                                    <input type='date' name='tanggal_pembayaran' id='tanggal_pembayaran'
                                        class='form-control @error('tanggal_pembayaran') is-invalid @enderror'
                                        value='{{ $item->pembayaran ? $item->pembayaran->tanggal_pembayaran : old('tanggal_pembayaran') }}'>
                                    @error('tanggal_pembayaran')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                
                                @if ($item->pembayaran->bukti_pembayaran)
                                <p>Bukti Pembayaran :</p>
                                    <img width="20%" src="{{asset($item->pembayaran->bukti_pembayaran)}}" alt="">
                                @else
                                <div class='form-group mb-3'>
                                    <label for='bukti_pembayaran' class='mb-2'>Bukti Pembayaran</label>
                                    <input type='file' name='bukti_pembayaran' id='bukti_pembayaran'
                                        accept='image/*'
                                        class='form-control @error('bukti_pembayaran') is-invalid @enderror'   >
                                    @error('bukti_pembayaran')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                @endif

                            @else
                                <div class='form-group mb-3'>
                                    <label for='sp' class='mb-2'>Status Pembayaran</label>
                                    <input type='text' name='sp' id='sp'
                                        class='form-control @error('sp') is-invalid @enderror'
                                        value='{{ $item->pembayaran ? $item->pembayaran->status_pembayaran : '-' }}'
                                        readonly>
                                    @error('sp')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class='form-group mb-3'>
                                    <label for='tgldbyr' class='mb-2'>Tanggal Dibayarkan</label>
                                    <input type='text' name='tgldbyr' id='tgldbyr'
                                        class='form-control @error('tgldbyr') is-invalid @enderror'
                                        value='{{ $item->pembayaran ? formatTanggal($item->pembayaran->tanggal_pembayaran) : '-' }}'
                                        readonly>
                                    @error('tgldbyr')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            
                            @if (!$item->pembayaran || $item->pembayaran->status_pembayaran !== 'Lunas')
                                <div class="form-group text-right">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
