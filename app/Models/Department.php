<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
    protected $guarded = ['id'];

    public function anggarans()
    {
        return $this->hasMany(Anggaran::class, 'department_id', 'id');
    }
}
