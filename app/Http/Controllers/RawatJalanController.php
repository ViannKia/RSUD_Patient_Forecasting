<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Imports\RawatJalanImport;
use App\Models\RawatJalan;

class RawatJalanController extends Controller
{
    public function index()
    {
        $data_jalan = RawatJalan::all();
        return view('rawatjalan.rawatjalan', compact('data_jalan'));
    }

    public function create()
    {
        $data_jalan = RawatJalan::all();
        return view('rawatjalan.rawatjalan', compact('data_jalan'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required|numeric',
            'bulan' => 'required',
            'jumlah_jalan' => 'required|numeric',
        ], [
            'tahun.required' => 'Silahkan Mengisi Tahun',
            'tahun.numeric' => 'Tahun hanya boleh berupa angka',
            'bulan.required' => 'Silahkan Memilih Bulan',
            'jumlah_jalan.required' => 'Silahkan Mengisi Jumlah Pasien',
            'jumlah_jalan.numeric' => 'Jumlah Pasien hanya boleh berupa angka',
        ]);

        RawatJalan::create([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'jumlah_jalan' => $request->jumlah_jalan,
        ]);

        return redirect('/rawatjalan')->with('success', 'Data berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $jalan = RawatJalan::findOrFail($id);
        return view('rawatjalan.rawatjalan', compact('jalan'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tahun' => 'required|numeric',
            'bulan' => 'required',
            'jumlah_jalan' => 'required|numeric',
        ]);

        $jalan = RawatJalan::findOrFail($id);
        $jalan->update([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'jumlah_jalan' => $request->jumlah_jalan,
        ]);

        return redirect('/rawatjalan')->with('success', 'Data berhasil diperbarui!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            // Debugging: cek apakah file diterima
            if ($request->hasFile('file')) {
                Log::info('File uploaded: ' . $request->file('file')->getClientOriginalName());
            } else {
                Log::error('No file uploaded.');
            }

            // Proses impor file
            Excel::import(new RawatJalanImport, $request->file('file'));
            session()->flash('import_success', true);
            return redirect('/rawatjalan')->with('success', 'Data berhasil diimport!');
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect('/rawatjalan')->with('error', 'Terjadi Kesalahan Saat Mengimport Data!');
        }
    }


    public function hapus($id)
    {
        $jalan = RawatJalan::findOrFail($id); // Menggunakan findOrFail untuk menangani buku yang tidak ditemukan
        $jalan->delete();
        return redirect('/rawatjalan')->with('success', 'Data berhasil dihapus!');
    }
}
