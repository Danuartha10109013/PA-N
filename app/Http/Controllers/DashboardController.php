<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reimbursment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $count = [
            'reimbursment_hari_ini' => Reimbursment::getBy()->where('status_pengajuan', 1)->whereDate('created_at', now())->count(),
            'rembursment_bulan_ini' => Reimbursment::getBy()->where('status_pengajuan', 1)->whereMonth('created_at', now()->month)->count(),
            'reimbursment_pending' => Reimbursment::getBy()->where('status_pengajuan', 0)->count(),
            'jumlah_reimbursment_bulan_ini' => Reimbursment::getBy()->where('status_pengajuan', 1)->whereMonth('created_at', now()->month)->sum('nominal')
        ];
        return view('pages.dashboard', [
            'title' => 'Dashboard',
            'count' => $count
        ]);
    }

    public function getData()
    {
        $items = DB::table('reimbursment')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(nominal) as total_nominal'))
            ->where('status_pengajuan', 1)
            ->where('created_at', '>=', now()->subDays(7)) // Ambil data 7 hari terakhir
            ->groupBy('date')
            ->orderBy('date', 'asc');
        if (auth()->user()->role !== 'staff keuangan') {
            $items = $items->where('user_id', auth()->id());
        }
        $data = $items->get();

        return response()->json($data);
    }
}
