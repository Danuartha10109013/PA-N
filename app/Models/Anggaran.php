<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'anggaran';
    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function sisa()
    {
        $nominal_anggaran = $this->nominal;
        $reimbursment_sukses =
            Reimbursment::whereYear('tanggal', $this->tahun)->whereMonth('tanggal', $this->bulan)->whereHas('pembayaran', fn($q) => $q->where('status_pembayaran', 'Lunas'))->sum('nominal');
        $sisa = $nominal_anggaran - $reimbursment_sukses;
        return $sisa;
    }
}
