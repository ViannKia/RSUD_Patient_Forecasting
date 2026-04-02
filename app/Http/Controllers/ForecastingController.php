<?php

namespace App\Http\Controllers;

use App\Models\RawatInap;
use App\Models\RawatJalan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ForecastingController extends Controller
{
    public function index(Request $request)
    {
        // Pilihan Rawat Inap dan Rawat Jalan
        $item = [
            (object) ['id' => 'rawat_inap', 'itemName' => 'Rawat Inap'],
            (object) ['id' => 'rawat_jalan', 'itemName' => 'Rawat Jalan']
        ];

        // Mengambil data tahun berdasarkan pilihan jenis rawat
        $years = collect(); // Inisialisasi dengan koleksi kosong

        if ($request->has('chooseItem')) {
            $itemChoice = $request->input('chooseItem');

            // Menampilkan tahun sesuai dengan jenis rawat yang dipilih
            if ($itemChoice == 'rawat_inap') {
                $years = RawatInap::select('tahun')->groupBy('tahun')->get();
            } elseif ($itemChoice == 'rawat_jalan') {
                $years = RawatJalan::select('tahun')->groupBy('tahun')->get();
            }
        }

        return view('forecasting.forecasting', compact('years', 'item'));
    }

    public function trendMoment(Request $request)
    {
        $selectedYear = $request->input('chooseYear');
        $selectedItem = $request->input('chooseItem');
        $forecastPeriod = $request->input('forecast_period');

        // Pastikan years disiapkan
        if ($selectedItem == 'rawat_inap') {
            $years = RawatInap::select('tahun')->groupBy('tahun')->get();
        } elseif ($selectedItem == 'rawat_jalan') {
            $years = RawatJalan::select('tahun')->groupBy('tahun')->get();
        } else {
            $years = collect();
        }

        $year = $request->input('chooseYear'); // Tahun yang dipilih untuk *data latih*
        $item = $request->input('chooseItem'); // Rawat Inap atau Rawat Jalan
        $forecastPeriod = (int) $request->input('forecast_period', 12); // Default 12 bulan

        // Menentukan nama item berdasarkan pilihan (Rawat Inap atau Rawat Jalan)
        $itemName = $item == 'rawat_inap' ? 'Rawat Inap' : 'Rawat Jalan';

        // Ambil data untuk perhitungan trend moment (data latih)
        if ($item == 'rawat_inap') {
            $data_latih = RawatInap::where('tahun', $year - 1)
                ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->get(['bulan', 'jumlah_inap']);
        } else {
            $data_latih = RawatJalan::where('tahun', $year - 1)
                ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->get(['bulan', 'jumlah_jalan']);
        }

        $actualData = [];
        if ($item == 'rawat_inap') {
            $actualData = RawatInap::where('tahun', $year)
                ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->get(['bulan', 'jumlah_inap']);
        } else {
            $actualData = RawatJalan::where('tahun', $year)
                ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
                ->get(['bulan', 'jumlah_jalan']);
        }

        // Data aktual tahun sebelumnya (dibutuhkan untuk bandingkan tren)
        $prevYearData = $item == 'rawat_inap' ?
            RawatInap::where('tahun', $year - 1)
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->pluck('jumlah_inap')->toArray()
            :
            RawatJalan::where('tahun', $year - 1)
            ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
            ->pluck('jumlah_jalan')->toArray();


        // Mengambil data aktual yang relevan
        $actualY = $item == 'rawat_inap' ? $actualData->pluck('jumlah_inap')->toArray() : $actualData->pluck('jumlah_jalan')->toArray();


        // Mengambil data aktual (jumlah_inap atau jumlah_jalan)
        $y = $item == 'rawat_inap' ? $data_latih->pluck('jumlah_inap')->toArray() : $data_latih->pluck('jumlah_jalan')->toArray();
        $n = count($y);

        $x = range(0, $n - 1);

        // Inisialisasi variabel sumasi
        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXY = 0;
        $sumX2 = 0;

        // Menghitung nilai sumasi
        for ($i = 0; $i < $n; $i++) {
            $sumXY += $x[$i] * $y[$i];
            $sumX2 += $x[$i] * $x[$i];
        }

        // Menghitung koefisien kemiringan (b)
        $numerator = ($n * $sumXY) - ($sumX * $sumY);
        $denominator = ($n * $sumX2) - ($sumX * $sumX);

        // Menghindari pembagian dengan nol
        $b = ($denominator != 0) ? ($numerator / $denominator) : 0;

        // Menghitung intersep (a)
        if ($n != 0) {
            $a = ($sumY - ($b * $sumX)) / $n;
        } else {
            // Tangani jika $n = 0, misalnya dengan memberi nilai default atau error handling
            $a = 0;  // Atau nilai lain yang sesuai
        }

        //

        // Menghitung prediksi untuk 12 bulan ke depan
        $newDate = [];
        $start = Carbon::create($year, 1, 1);
        for ($i = 0; $i < $forecastPeriod; $i++) {
            $newDate[] = $start->copy()->addMonths($i)->format('F Y');
        }

        // Menghitung prediksi nilai Y (jumlah pasien) untuk 12 bulan ke depan
        $predictedY = array_map(function ($a, $b, $x) {
            return $a + $b * $x;
        }, array_fill(0, $forecastPeriod, $a), array_fill(0, $forecastPeriod, $b), range(12, 11 + $forecastPeriod));

        // Membulatkan hasil prediksi Y
        $roundedY = array_map(function ($predicted) {
            return round($predicted); // Membulatkan nilai prediksi
        }, $predictedY);

        // Hitung perubahan bulan ke bulan pada data prediksi (roundedY)
        $diffs = [];
        for ($i = 0; $i < count($roundedY); $i++) {
            $actualVal = $actualY[$i] ?? null;
            if ($actualVal === null) {
                continue; // skip kalau data actual gak ada
            }
            $diffs[$i] = $roundedY[$i] - $actualVal;
        }

        if (!empty($diffs)) {
            $maxIncreaseValue = max($diffs);
            $maxIncreaseIndex = array_search($maxIncreaseValue, $diffs);

            $maxDecreaseValue = min($diffs);
            $maxDecreaseIndex = array_search($maxDecreaseValue, $diffs);

            $maxDecreaseValueAbs = abs($maxDecreaseValue);

            $monthMaxIncrease = $newDate[$maxIncreaseIndex];
            $monthMaxDecrease = $newDate[$maxDecreaseIndex];

            // Ambil nilai aktual dari indeks yang ditemukan
            $actualValIncrease = $actualY[$maxIncreaseIndex] ?? 0;
            $actualValDecrease = $actualY[$maxDecreaseIndex] ?? 0;

            // Hitung persen kenaikan/penurunan
            $percentIncrease = ($actualValIncrease != 0) ? round(($maxIncreaseValue / $actualValIncrease) * 100, 2) : 0;
            $percentDecrease = ($actualValDecrease != 0) ? round(($maxDecreaseValueAbs / $actualValDecrease) * 100, 2) : 0;
        } else {
            $maxIncreaseValue = $maxIncreaseIndex = $maxDecreaseValue = $maxDecreaseIndex = null;
            $monthMaxIncrease = $monthMaxDecrease = 'Data tidak tersedia';
            $percentIncrease = $percentDecrease = null;
        }

        // Menghitung MAPE (Mean Absolute Percentage Error) menggunakan data aktual untuk tahun yang diramalkan
        $sumAbsErAt = null;
        $mape = null;
        $er = $absEr = $resultAbsErAt = [];
        $isActualAvailable = !empty($actualY) && count($actualY) >= $forecastPeriod;

        if ($isActualAvailable) {
            $actualSlice = array_slice($actualY, 0, $forecastPeriod);
            $forecastSlice = array_slice($roundedY, 0, $forecastPeriod);

            $er = array_map(fn($at, $ft) => $at - $ft, $actualSlice, $forecastSlice);
            $absEr = array_map(fn($er) => abs($er), $er);
            $resultAbsErAt = array_map(fn($absEr, $at) => abs($absEr / $at), $absEr, $actualSlice);

            $sumAbsErAt = array_sum($resultAbsErAt);
            $mape = $sumAbsErAt / count($actualSlice) * 100;
        } else {
            $mape = null;
        }

        $trendStatus = [];
        for ($i = 0; $i < $forecastPeriod; $i++) {
            $forecastValue = $roundedY[$i] ?? null;
            $prevValue = $prevYearData[$i] ?? null;

            if ($forecastValue === null || $prevValue === null) {
                $trendStatus[] = 'Tidak Diketahui';
            } elseif ($forecastValue > $prevValue) {
                $trendStatus[] = 'Jumlah Pasien Naik';
            } elseif ($forecastValue < $prevValue) {
                $trendStatus[] = 'Jumlah Pasien Turun';
            } else {
                $trendStatus[] = 'Jumlah Pasien Tetap';
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'newDate' => $newDate,
                'actualY' => $actualY,
                'roundedY' => $roundedY,
                'mape' => $mape,
                'prevYearData' => $prevYearData,
                'monthMaxIncrease' => $monthMaxIncrease,
                'maxIncreaseValue' => $maxIncreaseValue,
                'monthMaxDecrease' => $monthMaxDecrease,
                'maxDecreaseValue' => $maxDecreaseValue,
                'percentDecrease' => $percentDecrease,
                'percentIncrease' => $percentIncrease,
                'isActualAvailable' => $isActualAvailable,
            ]);
        } else {
            // Jika ini bukan permintaan AJAX, kembalikan view
            return view('forecasting.forecasting', compact(
                'newDate',
                'itemName',
                'y',
                'roundedY',
                'er',
                'absEr',
                'resultAbsErAt',
                'sumAbsErAt',
                'mape',
                'trendStatus',
                'prevYearData',
                'actualY',
                'monthMaxIncrease',
                'maxIncreaseValue',
                'monthMaxDecrease',
                'maxDecreaseValue',
                'percentDecrease',
                'percentIncrease',
                'isActualAvailable',
                'years',
                'selectedYear',
                'selectedItem',
                'forecastPeriod',
            ));
        }
    }
}
