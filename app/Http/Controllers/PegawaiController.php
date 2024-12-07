<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = User::orderBy('name', 'ASC')->get();
        return view('pages.pegawai.index', [
            'title' => 'User',
            'users' => $pegawais
        ]);
    }

    public function create()
    {
        return view('pages.pegawai.create', [
            'title' => 'Tambah Pegawai',
            'departments' => Department::orderBy('nama', 'ASC')->get()
        ]);
    }

    public function store()
    {
        request()->validate([
            'name' => ['required', 'min:3'],
            'nip' => ['required', 'unique:users,nip'],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'alamat' => ['required'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['min:5', 'confirmed'],
            'role' => ['required'],
            'department_id' => ['required'],
            'avatar' => ['image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['name', 'email', 'nip', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'role', 'department_id']);
            $data['password'] = bcrypt(request('password'));
            request()->file('avatar') ? $data['avatar'] = request()->file('avatar')->store('pegawai', 'public') : NULL;
            User::create($data);
            DB::commit();
            return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $pegawai = User::where('id', '!=', auth()->id())->where('id', $id)->firstOrFail();
        return view('pages.pegawai.edit', [
            'title' => 'Edit User',
            'user' => $pegawai,
            'departments' => Department::orderBy('nama', 'ASC')->get()
        ]);
    }

    public function update($id)
    {
        $pegawai = User::findOrFail($id);
        request()->validate([
            'name' => ['required', 'min:3'],
            'nip' => ['required', 'unique:users,nip,' . $id . ''],
            'jenis_kelamin' => ['required'],
            'tempat_lahir' => ['required'],
            'tanggal_lahir' => ['required'],
            'alamat' => ['required'],
            'email' => ['required', 'unique:users,email,' . $id . ''],
            'role' => ['required'],
            'department_id' => ['required'],
            'avatar' => ['image', 'mimes:jpg,jpeg,png,svg', 'max:2048']
        ]);

        if (request('password')) {
            request()->validate([
                'password' => ['min:5', 'confirmed'],
            ]);
        }

        DB::beginTransaction();
        try {
            $data = request()->only(['name', 'email', 'nip', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'role', 'department_id']);
            request('password') ? $data['password'] = bcrypt(request('password')) : NULL;
            request()->file('avatar') ? $data['avatar'] = request()->file('avatar')->store('pegawai', 'public') : NULL;
            $pegawai->update($data);
            DB::commit();
            return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        $pegawai = User::findOrFail($id);

        DB::beginTransaction();
        try {
            $pegawai->delete();
            DB::commit();
            return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
