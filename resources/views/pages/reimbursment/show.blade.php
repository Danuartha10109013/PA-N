@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Detail Pengajuan Reimbursment</h4>

                    <ul class="list-unstyled">
                        <li class="d-flex justify-content-between mb-2">
                            <span>Kode</span>
                            <span>{{ $item->kode }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>NIP</span>
                            <span>{{ $item->user->nip }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Nama</span>
                            <span>{{ $item->user->name }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Kategori</span>
                            <span>{{ $item->kategori->nama }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Deskripsi</span>
                            <span>{{ $item->deskripsi }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Nominal</span>
                            <span>{{ formatRupiah($item->nominal) }}</span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Bukti</span>
                            <span>
                                <a href="{{ $item->bukti() }}" target="_blank">Lihat</a>
                            </span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Surat Jalan</span>
                            <span>
                                <a href="{{ $item->surat_jalan() }}" target="_blank">Lihat</a>
                            </span>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>Status</span>
                            <span>{!! $item->status() !!}</span>
                        </li>
                        @if ($item->status_pengajuan == 2)
                            <li class="d-flex justify-content-between mb-2">
                                <span>Alasan Ditolak</span>
                                <span>{{ $item->catatan }}</span>
                            </li>
                        @endif
                        <hr>
                        <h5>Anggaran</h5>
                        @if ($anggaran)
                            <li class="d-flex justify-content-between mb-2">
                                <span>Department </span>
                                <span>{{ $item->user->department->nama }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Bulan/Tahun </span>
                                <span>{{ getMonthName($anggaran->bulan) . '/' . $anggaran->tahun }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Sisa Anggaran</span>
                                <span>{{ formatRupiah($anggaran->sisa()) }}</span>
                            </li>
                        @else
                            Tidak Ada Anggaran
                        @endif
                        @if ($item->pembayaran)
                            <hr>
                            <h5>Pembayaran</h5>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Metode Pembayaran </span>
                                <span>{{ $item->pembayaran->metode_pembayaran }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Nomor Rekening </span>
                                <span>{{ $item->pembayaran->nomor_rekening }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Pemilik </span>
                                <span>{{ $item->pembayaran->pemilik }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Tanggal Dibayarkan</span>
                                <span>{{ formatTanggal($item->pembayaran->tanggal_pembayaran) }}</span>
                            </li>
                            <li class="d-flex justify-content-between mb-2">
                                <span>Bukti Pembayaraan : </span> <br>
                            </li>
                            <li>
                                <span><img src="{{asset($item->pembayaran->bukti_pembayaran)}}" width="20%" alt=""></span>
                            </li>
                        @endif
                        @if ($anggaran && $item->status_pengajuan == 0)
                            <li class="d-flex justify-content-between mb-2">
                                <span>Aksi </span>
                                <div>
                                    @if (role_staff_keuangan())
                                        <button data-toggle="modal" data-target="#modalSetujui"
                                            class="btn btn-sm btn-success btnSetujui">Set Setujui</button>
                                        <button data-toggle="modal" data-target="#modalTolak"
                                            class="btn btn-sm btn-danger btnTolak">Set Tolak</button>
                                    @endif

                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalSetujui" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anda Yakin?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reimbursment.setujui', $item->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <p>Setelah disetujui, maka sisa anggaran department nya akan dikurangi.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yakin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alasan Ditolak</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reimbursment.tolak', $item->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <label for='catatan' class='mb-2'>Catatan</label>
                            <textarea name='catatan' id='catatan' cols='30' rows='3'
                                class='form-control @error('catatan') is-invalid @enderror'>{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalPembayaran" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Atur Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reimbursment.tolak', $item->id) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class='form-group mb-3'>
                            <label for='catatan' class='mb-2'>Catatan</label>
                            <textarea name='catatan' id='catatan' cols='30' rows='3'
                                class='form-control @error('catatan') is-invalid @enderror'>{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
