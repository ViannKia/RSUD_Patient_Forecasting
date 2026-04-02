{{-- Modal Update Data --}}
<div class="modal fade" id="modalinapupdate" tabindex="-1" aria-labelledby="modalinapupdateLabel"
aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <form id="updateForm" method="POST">
            <input type="hidden" name="_from" value="updateinap">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="modalinapLabel">Update Data Rawat Inap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="tahun">Tahun</label>
                    <input class="form-control" id="updateTahun" name="tahun"
                        value="{{ old('tahun', isset($inap) ? $inap->tahun : '') }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="bulan">Bulan</label>
                    <select class="form-select" id="updateBulan" name="bulan" required>
                        <option value="">-- Pilih Bulan --</option>
                        @php
                            $selectedBulan = old('bulan', isset($inap) ? $inap->bulan : '');
                        @endphp
                        @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                            <option value="{{ $bulan }}"
                                {{ $selectedBulan == $bulan ? 'selected' : '' }}>{{ $bulan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="jumlah_inap">Jumlah Pasien</label>
                    <input class="form-control" id="updateJumlah" name="jumlah_inap"
                        value="{{ old('jumlah_inap', isset($inap) ? $inap->jumlah_inap : '') }}" required>
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