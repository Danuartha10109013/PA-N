<?php

namespace App\Http\Controllers;

use App\Models\Reimbursment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $items = Reimbursment::getByUser()->orderBy('id', 'DESC')->get();
        return view('pages.laporan.index', [
            'title' => 'Laporan',
            'items' => $items
        ]);
    }

    public function print()
    {
        $tanggal_awal = request('tanggal_awal');
        $tanggal_akhir = request('tanggal_akhir');
        $status = request('status');
        $data = Reimbursment::getByUser();

        if ($tanggal_awal && $tanggal_akhir) {
            $data->whereDate('created_at', '>=', $tanggal_awal);
            $data->whereDate('created_at', '<=', $tanggal_akhir);
        } elseif ($tanggal_awal && !$tanggal_akhir) {
            $data->whereDate('created_at', $tanggal_awal);
        }
        if ($status !== 'all') {
            $data->where('status_pengajuan', $status);
        }
        $items = $data->latest()->get();
        // dd($items);
        $pdf = Pdf::loadView('pages.laporan.export-pdf', [
            'items' => $items,
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'status' => $status
        ]);
        return $pdf->stream('laporan-reimbursment.pdf');
    }
}
