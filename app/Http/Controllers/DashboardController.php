<?php

namespace App\Http\Controllers;

use App\Models\RawatInap;
use App\Models\RawatJalan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $yearInap = RawatInap::max('tahun');
        $yearJalan = RawatJalan::max('tahun');

        // total dan prev total per masing-masing tahun
        $totalInap = RawatInap::where('tahun', $yearInap)->sum('jumlah_inap');
        $prevTotalInap = RawatInap::where('tahun', $yearInap - 1)->sum('jumlah_inap');

        $totalJalan = RawatJalan::where('tahun', $yearJalan)->sum('jumlah_jalan');
        $prevTotalJalan = RawatJalan::where('tahun', $yearJalan - 1)->sum('jumlah_jalan');

        $growthInap = $prevTotalInap > 0 ? (($totalInap - $prevTotalInap) / $prevTotalInap) * 100 : null;
        $growthJalan = $prevTotalJalan > 0 ? (($totalJalan - $prevTotalJalan) / $prevTotalJalan) * 100 : null;

        // Data bulanan untuk chart (lengkapi 12 bulan dengan 0 jika kurang)
        $dataInap = RawatInap::where('tahun', $yearInap)->orderBy('bulan')->pluck('jumlah_inap')->toArray();
        $dataJalan = RawatJalan::where('tahun', $yearJalan)->orderBy('bulan')->pluck('jumlah_jalan')->toArray();

        $dataInap = array_pad($dataInap, 12, 0);
        $dataJalan = array_pad($dataJalan, 12, 0);

        return view('dashboard', compact(
            'totalInap',
            'totalJalan',
            'yearInap',
            'yearJalan',
            'growthInap',
            'growthJalan',
            'dataInap',
            'dataJalan'
        ));
    }
}
