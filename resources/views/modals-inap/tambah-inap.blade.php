{{-- Modal Tambah Data --}}
<div class="modal fade" id="modalinap" tabindex="-1" aria-labelledby="modalinapLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/rawatinap/store') }}" method="POST" id="formTambahManual">
                @csrf
                <input type="hidden" name="_from" value="inap">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalinapLabel">Tambah Data Rawat Inap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="tahun">Tahun</label>
                        <input type="text" class="form-control @error('tahun') is-invalid @enderror" id="tahun"
                            name="tahun" value="{{ old('tahun') }}">
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="bulan">Bulan</label>
                        <select class="form-select @error('bulan') is-invalid @enderror" id="bulan" name="bulan">
                            <option value="">-- Pilih Bulan --</option>
                            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bln)
                                <option value="{{ $bln }}" {{ old('bulan') == $bln ? 'selected' : '' }}>
                                    {{ $bln }}</option>
                            @endforeach
                        </select>
                        @error('bulan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="jumlah_inap">Jumlah Pasien</label>
                        <input type="text" class="form-control @error('jumlah_inap') is-invalid @enderror"
                            id="jumlah_inap" name="jumlah_inap" value="{{ old('jumlah_inap') }}">
                        @error('jumlah_inap')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
@endpush
