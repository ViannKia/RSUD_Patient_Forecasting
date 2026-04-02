<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatInap extends Model
{
    use HasFactory;

    protected $table = 'tb_rawatinap';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'tahun', 'bulan', 'jumlah_inap'
    ];

    public $timestamps = true;
}

