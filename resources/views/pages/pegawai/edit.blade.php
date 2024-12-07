@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Pegawai</h4>
                    <form action="{{ route('pegawai.update', $user->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='avatar' class='mb-2'>Avatar</label>
                            <input type='file' name='avatar' class='form-control @error('avatar') is-invalid @enderror'
                                value='{{ old('avatar') }}'>
                            @error('avatar')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nip' class='mb-2'>NIP</label>
                            <input type='text' name='nip' class='form-control @error('nip') is-invalid @enderror'
                                value='{{ $user->nip ?? old('nip') }}'>
                            @error('nip')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='name' class='mb-2'>Nama</label>
                            <input type='text' name='name' class='form-control @error('name') is-invalid @enderror'
                                value='{{ $user->name ?? old('name') }}'>
                            @error('name')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='jenis_kelamin'>Jenis Kelamin</label>
                            <select name='jenis_kelamin' id='jenis_kelamin'
                                class='form-control @error('jenis_kelamin') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Jenis Kelamin</option>
                                <option @selected($user->jenis_kelamin === 'Laki-laki') value="Laki-laki">Laki-laki</option>
                                <option @selected($user->jenis_kelamin === 'Perempuan') value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tempat_lahir' class='mb-2'>Tempat Lahir</label>
                            <input type='text' name='tempat_lahir' id='tempat_lahir'
                                class='form-control @error('tempat_lahir') is-invalid @enderror'
                                value='{{ $user->tempat_lahir ?? old('tempat_lahir') }}'>
                            @error('tempat_lahir')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='tanggal_lahir' class='mb-2'>Tanggal Lahir</label>
                            <input type='date' name='tanggal_lahir' id='tanggal_lahir'
                                class='form-control @error('tanggal_lahir') is-invalid @enderror'
                                value='{{ $user->tanggal_lahir ?? old('tanggal_lahir') }}'>
                            @error('tanggal_lahir')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='alamat' class='mb-2'>Alamat</label>
                            <textarea name='alamat' id='alamat' cols='30' rows='3'
                                class='form-control @error('alamat') is-invalid @enderror'>{{ $user->alamat ?? old('alamat') }}</textarea>
                            @error('alamat')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group'>
                            <label for='department_id'>Department</label>
                            <select name='department_id' id='department_id'
                                class='form-control @error('department_id') is-invalid @enderror'>
                                <option value='' selected disabled>Pilih Department</option>
                                @foreach ($departments as $department)
                                    <option @selected($department->id == $user->department_id ?? old('department_id')) value='{{ $department->id }}'>
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
                        <div class='form-group mb-3'>
                            <label for='email' class='mb-2'>Email</label>
                            <input type='text' name='email' class='form-control @error('email') is-invalid @enderror'
                                value='{{ $user->email ?? old('email') }}'>
                            @error('email')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='role' class='mb-2'>Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Role</option>
                                <option @selected($user->role === 'staff keuangan') value="staff keuangan">Staff Keuangan</option>
                                <option @selected($user->role === 'staff umum') value="staff umum">Staff Umum</option>
                            </select>
                            @error('role')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='password' class='mb-2'>Password</label>
                            <input type='password' name='password'
                                class='form-control @error('password') is-invalid @enderror'
                                value='{{ old('password') }}'>
                            @error('password')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='password_confirmation' class='mb-2'>Password Confirmation</label>
                            <input type='password' name='password_confirmation'
                                class='form-control @error('password_confirmation') is-invalid @enderror'
                                value='{{ old('password_confirmation') }}'>
                            @error('password_confirmation')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('pegawai.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Pegawai</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {
            $('#roles').select2({
                theme: 'bootstrap',
                placeholder: 'Anda bisa memilih lebih dari 1 role'
            })
        })
    </script>
@endpush
