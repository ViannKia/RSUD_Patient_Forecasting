<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Imports\RawatInapImport;
use App\Models\RawatInap;

class RawatInapController extends Controller
{
    public function index()
    {
        $data_inap = RawatInap::all();
        return view('rawatinap.rawatinap', compact('data_inap'));
    }

    public function create()
    {
        $data_inap = RawatInap::all();
        return view('rawatinap.rawatinap', compact('data_inap'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tahun' => 'required|numeric',
            'bulan' => 'required',
            'jumlah_inap' => 'required|numeric',
        ], [
            'tahun.required' => 'Silahkan Mengisi Tahun',
            'tahun.numeric' => 'Tahun hanya boleh berupa angka',
            'bulan.required' => 'Silahkan Memilih Bulan',
            'jumlah_inap.required' => 'Silahkan Mengisi Jumlah Pasien',
            'jumlah_inap.numeric' => 'Jumlah Pasien hanya boleh berupa angka',
        ]);

        RawatInap::create([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'jumlah_inap' => $request->jumlah_inap,
        ]);

        return redirect('/rawatinap')->with('success', 'Data berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $inap = RawatInap::findOrFail($id);
        return view('rawatinap.rawatinap', compact('inap'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'tahun' => 'required|numeric',
            'bulan' => 'required',
            'jumlah_inap' => 'required|numeric',
        ]);

        $inap = RawatInap::findOrFail($id);
        $inap->update([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'jumlah_inap' => $request->jumlah_inap,
        ]);

        return redirect('/rawatinap')->with('success', 'Data berhasil diperbarui!');
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
            Excel::import(new RawatInapImport, $request->file('file'));
            session()->flash('import_success', true);
            return redirect('/rawatinap')->with('success', 'Data Berhasil Diimport!');
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect('/rawatinap')->with('error', 'Terjadi Kesalahan Saat Mengimport Data!');
        }
    }

    public function hapus($id)
    {
        $inap = RawatInap::findOrFail($id); // Menggunakan findOrFail untuk menangani buku yang tidak ditemukan
        $inap->delete();
        return redirect('/rawatinap')->with('success', 'Data Berhasil Dihapus!');
    }
}
