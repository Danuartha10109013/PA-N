@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Pegawai</h4>
                    <a href="{{ route('pegawai.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                        Pegawai</a>
                    <div class="table-responsive">
                        <table class="table nowrap dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Avatar</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $user->avatar() }}" class="img-fluid" alt="">
                                        </td>
                                        <td>{{ $user->nip }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->jenis_kelamin }}</td>
                                        <td>{{ $user->tempat_lahir }}</td>
                                        <td>{{ $user->tanggal_lahir }}</td>
                                        <td>{{ $user->alamat }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            {{ $user->role }}
                                        </td>
                                        <td>
                                            @if ($user->id != auth()->id())
                                                <a href="{{ route('pegawai.edit', $user->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('pegawai.destroy', $user->id) }}">Hapus</button>
                                                </form>
                                            @else
                                                <div class="text-danger font-italic">
                                                    Tidak Ada Akses
                                                </div>
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
