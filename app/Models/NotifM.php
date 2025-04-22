<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifM extends Model
{
    protected $table = 'notification';

    protected $fillable = [
        'title',
        'value',
        'status',
        'pengirim',
    ];
}
