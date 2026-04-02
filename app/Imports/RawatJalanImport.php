<?php

namespace App\Imports;

use App\Models\RawatJalan;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RawatJalanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Memastikan data yang diproses adalah data yang benar, bukan header
        if ($row['tahun'] === 'tahun') {
            return null; // Skip row header
        }

        Log::info('Processed Row: ' . print_r($row, true));  // Debugging

        return new RawatJalan([
            'tahun' => $row['tahun'],
            'bulan' => $row['bulan'],
            'jumlah_jalan' => $row['jumlah_jalan'],
        ]);
    }
}
