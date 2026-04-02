<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawatJalan extends Model
{
    use HasFactory;

    protected $table = 'tb_rawatjalan';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'tahun', 'bulan', 'jumlah_jalan'
    ];

    public $timestamps = true;
}
