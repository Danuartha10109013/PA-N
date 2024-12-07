@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Reimbursment</h4>
                    <div class="table-responsive">
                        <table class="table dtTable nowrap table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Nominal</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ formatTanggal($item->tanggal, 'd/m/Y H:i') }}</td>
                                        <td>{{ $item->user->nip }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ formatRupiah($item->nominal) }}</td>
                                        <td>{!! $item->status() !!}</td>
                                        <td>
                                            <a href="{{ route('reimbursment.show', $item->id) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                            @if ($item->status_pengajuan != 1 && role_staff_umum())
                                                <a href="{{ route('reimbursment.edit', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                            @endif
                                            @if ($item->status_pengajuan == 1)
                                                <a href="{{ route('reimbursment.pembayaran', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-info"> Pembayaran</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Datatable />
