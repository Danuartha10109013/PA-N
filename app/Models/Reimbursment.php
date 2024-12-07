<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reimbursment extends Model
{
    protected $table = 'reimbursment';
    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function staff_keuangan()
    {
        return $this->belongsTo(User::class, 'keuangan_user_id', 'id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'reimbursment_id', 'id');
    }

    public function scopeGetByUser($q)
    {
        if (role_staff_umum()) {
            $q->where('user_id', auth()->id());
        }
    }

    public static function getNewCode(): string
    {
        $prefix = 'RMB';
        $lastReimbursement = self::orderBy('id', 'desc')->first();
        if (!$lastReimbursement) {
            $nextNumber = 1;
        } else {
            $lastNumber = (int) substr($lastReimbursement->kode, strlen($prefix));
            $nextNumber = $lastNumber + 1;
        }
        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function status()
    {
        if ($this->status_pengajuan == 0) {
            return '<span class="badge badge-warning">Menunggu Persetujuan Keuangan</span>';
        } else if ($this->status_pengajuan == 1) {
            return '<span class="badge badge-success">Disetujui</span>';
        } else {
            return '<span class="badge badge-danger">Ditolak</span>';
        }
    }

    public function bukti()
    {
        return asset('storage/' . $this->bukti);
    }
    public function surat_jalan()
    {
        return asset('storage/' . $this->surat_jalan);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
