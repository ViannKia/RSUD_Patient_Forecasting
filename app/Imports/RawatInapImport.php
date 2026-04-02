<?php

namespace App\Imports;

use App\Models\RawatInap;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RawatInapImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Memastikan data yang diproses adalah data yang benar, bukan header
        if ($row['tahun'] === 'tahun') {
            return null; // Skip row header
        }

        Log::info('Processed Row: ' . print_r($row, true));  // Debugging

        return new RawatInap([
            'tahun' => $row['tahun'],
            'bulan' => $row['bulan'],
            'jumlah_inap' => $row['jumlah_inap'],
        ]);
    }
}
