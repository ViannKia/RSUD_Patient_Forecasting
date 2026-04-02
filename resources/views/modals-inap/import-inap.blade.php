<!-- Modal Rawat Inap -->
@section('css')
@endsection

<div class="modal fade" id="modalimportInap" tabindex="-1" aria-labelledby="modalimportLabelInap" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('/rawatinap/import') }}" method="POST" enctype="multipart/form-data" id="formImportInap">
                @csrf
                <input type="file" name="file" id="fileInputInap" style="display: none;">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalimportLabelInap">Import Data Rawat Inap</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="excelDropzone" class="dropzone">
                        <div class="dz-message">
                            <h6>Drag & Drop File Excel atau klik untuk memilih file</h6>
                            <p class="text-muted">Format file: .xlsx / .xls / .csv</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Import Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        const myDropzone = new Dropzone("#excelDropzone", {
            url: "#",
            autoProcessQueue: false,
            maxFiles: 1,
            acceptedFiles: ".xlsx,.xls,.csv",
            paramName: "file",
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            init: function() {
                this.on("addedfile", function(file) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    document.getElementById('fileInputInap').files = dataTransfer.files;

                    const preview = file.previewElement;
                    if (preview) {
                        preview.classList.add("dz-processing", "dz-success", "dz-complete");
                        let uploadBar = preview.querySelector(".dz-upload");
                        if (!uploadBar) {
                            uploadBar = document.createElement("div");
                            uploadBar.className = "dz-upload";
                            preview.appendChild(uploadBar);
                        }
                        uploadBar.style.width = "100%";
                    }
                });
            }
        });
    </script>
@endpush
