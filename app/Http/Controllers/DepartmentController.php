<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $items = Department::orderBy('nama', 'ASC')->get();
        return view('pages.department.index', [
            'title' => 'Department',
            'items' => $items
        ]);
    }

    public function create()
    {
        return view('pages.department.create', [
            'title' => 'Tambah Department'
        ]);
    }

    public function store()
    {

        request()->validate([
            'nama' => ['required', 'unique:department,nama'],
        ]);

        DB::beginTransaction();
        try {
            $data = request()->only(['nama']);
            Department::create($data);

            DB::commit();
            return redirect()->route('department.index')->with('success', 'Department berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Department::findOrFail($id);
        return view('pages.department.edit', [
            'title' => 'Edit department',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nama' => ['required', 'unique:department,nama,' . $id . ''],
        ]);

        DB::beginTransaction();
        try {
            $item = Department::findOrFail($id);
            $data = request()->only(['nama']);
            $item->update($data);

            DB::commit();
            return redirect()->route('department.index')->with('success', 'Department berhasil diupdate.');
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
            $item = Department::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('department.index')->with('success', 'Department berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
