{{-- Modal Update Data --}}
<div class="modal fade" id="modaljalanupdate" tabindex="-1" aria-labelledby="modaljalanupdateLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <form id="updateForm" method="POST">
            <input type="hidden" name="_from" value="updatejalan">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modaljalanLabel">Update Data Rawat Jalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="tahun">Tahun</label>
                    <input class="form-control" id="updateTahun" name="tahun"
                        value="{{ old('tahun', isset($jalan) ? $jalan->tahun : '') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="bulan">Bulan</label>
                    <select class="form-select" id="updateBulan" name="bulan" required>
                        <option value="">-- Pilih Bulan --</option>
                        @php
                            $selectedBulan = old('bulan', isset($jalan) ? $jalan->bulan : '');
                        @endphp
                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                            <option value="{{ $bulan }}"
                                {{ $selectedBulan == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="jumlah_jalan">Jumlah Pasien</label>
                    <input class="form-control" id="updateJumlah" name="jumlah_jalan"
                        value="{{ old('jumlah_jalan', isset($jalan) ? $jalan->jumlah_jalan : '') }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
</div>
</div>