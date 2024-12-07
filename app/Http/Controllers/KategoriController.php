<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        $items = Kategori::orderBy('nama', 'ASC')->get();
        return view('pages.kategori.index', [
            'title' => 'Kategori',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.kategori.create', [
            'title' => 'Tambah Kategori'
        ]);
    }

    public function store()
    {

        request()->validate([
            'nama' => ['required', 'unique:jabatan,nama'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Kategori::create($data);

            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Kategori::findOrFail($id);
        return view('pages.kategori.edit', [
            'title' => 'Edit Jabatan',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:jabatan,nama,' . $id . ''],
        ]);

        DB::beginTransaction();
        try {
            $item = Kategori::findOrFail($id);
            $data = request()->only(['nama']);
            $item->update($data);

            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $item = Kategori::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
