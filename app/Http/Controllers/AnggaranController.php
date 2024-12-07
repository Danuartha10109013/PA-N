<?php

namespace App\Http\Controllers;

use App\Helpers\MonthHelper;
use App\Models\Anggaran;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggaranController extends Controller
{
    public function index()
    {
        $items = Anggaran::with('department')->orderBy('id', 'DESC')->get();
        return view('pages.anggaran.index', [
            'title' => 'Anggaran',
            'items' => $items
        ]);
    }

    public function create()
    {
        $departments = Department::orderBy('nama', 'ASC')->get();
        $months = getAllMonths();
        return view('pages.anggaran.create', [
            'title' => 'Tambah Anggaran',
            'departments' => $departments,
            'months' => $months
        ]);
    }

    public function store()
    {
        request()->validate([
            'department_id' => ['required'],
            'tahun' => ['required', 'numeric'],
            'bulan' => ['required', 'numeric'],
            'nominal' => ['required', 'numeric'],
        ]);

        // cek data per department tahun dan bulan
        $cek = Anggaran::where([
            'department_id' => request('department_id'),
            'tahun' => request('tahun'),
            'bulan' => request('bulan'),
        ])->count();

        if ($cek > 0) {
            return redirect()->back()->with('error', 'Anggaran department tersebut sudah ada.');
        }

        DB::beginTransaction();
        try {
            $data = request()->only(['department_id', 'tahun', 'bulan', 'nominal']);
            $data['sisa'] = request('nominal');
            Anggaran::create($data);

            DB::commit();
            return redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        $item = Anggaran::findOrFail($id);
        return view('pages.anggaran.edit', [
            'title' => 'Edit Anggaran',
            'item' => $item
        ]);
    }

    public function update($id)
    {
        request()->validate([
            'nominal' => ['required', 'numeric'],
        ]);

        $item = Anggaran::findOrFail($id);

        DB::beginTransaction();
        try {
            $data = request()->only(['nominal']);
            $item->update($data);
            DB::commit();
            return redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil diupdate.');
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
            $item = Anggaran::findOrFail($id);
            $item->delete();
            DB::commit();
            return redirect()->route('anggaran.index')->with('success', 'Anggaran berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            // throw $th;
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
