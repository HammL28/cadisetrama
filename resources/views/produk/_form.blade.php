@csrf

{{-- CDN CSS Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    :root {
        --purple-main: #7c3aed;
        --purple-dark: #5b21b6;
        --purple-soft: #f3e8ff;
        --gray-border: #e9d5ff;
    }

    .form-card-section {
        background-color: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--gray-border);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.04);
    }

    .form-label-custom {
        font-weight: 600;
        color: #2e1065;
        font-size: 0.875rem;
        margin-bottom: 0.4rem;
        display: inline-block;
    }

    .input-group-custom .input-group-text {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #64748b;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        font-weight: 600;
    }

    .form-control-custom {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 0.65rem 0.9rem;
        font-size: 0.9rem;
        transition: all 0.2s ease-in-out;
    }

    .input-group-custom .form-control-custom {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-control-custom:focus {
        border-color: var(--purple-main) !important;
        box-shadow: 0 0 0 3.5px rgba(124, 58, 237, 0.15) !important;
    }

    /* Kustomisasi Tampilan Select2 */
    .select2-container--bootstrap-5 .select2-selection {
        border-radius: 0 10px 10px 0 !important;
        border-color: #cbd5e1 !important;
        padding: 0.5rem 0.8rem !important;
        min-height: 43px !important;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--purple-main) !important;
        box-shadow: 0 0 0 3.5px rgba(124, 58, 237, 0.15) !important;
    }

    /* AREA UNGGAH FOTO */
    .file-upload-box {
        border: 2px dashed #cbd5e1;
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .file-upload-box:hover {
        border-color: var(--purple-main);
        background-color: var(--purple-soft);
    }

    .file-upload-box input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    /* TOMBOL */
    .btn-gradient-submit {
        background: linear-gradient(135deg, #7c3aed, #9333ea);
        border: none;
        color: white;
        padding: 0.7rem 1.8rem;
        border-radius: 50px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.25);
        transition: all 0.2s ease;
    }

    .btn-gradient-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(124, 58, 237, 0.35);
        color: white;
    }

    .btn-soft-secondary {
        background: #f1f5f9;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 0.7rem 1.8rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-soft-secondary:hover {
        background: #e2e8f0;
        color: #334155;
    }
</style>

<div class="row g-4">

    {{-- UNGGAH FOTO PRODUK --}}
    <div class="col-12">
        <div class="p-4 form-card-section">
            <label class="form-label-custom">Foto Produk</label>

            <div class="file-upload-box mb-2" id="dropArea">
                <input type="file"
                    name="foto"
                    id="fotoInput"
                    onchange="previewImage(this)"
                    accept="image/*">

                <div id="uploadPlaceholder" style="{{ isset($produk) && $produk->foto ? 'display:none;' : '' }}">
                    <i class="bi bi-cloud-arrow-up fs-1" style="color: var(--purple-main);"></i>
                    <p class="mb-1 mt-2 fw-semibold text-dark">Klik atau seret foto ke sini untuk mengunggah</p>
                    <span class="text-muted small">Format yang didukung: JPG, PNG, WEBP (Maksimal 2MB)</span>
                </div>

                {{-- PRATINJAU FOTO --}}
                <div id="previewContainer" class="mt-2" style="{{ isset($produk) && $produk->foto ? '' : 'display:none;' }}">
                    <div class="position-relative d-inline-block">
                        <img id="preview"
                            src="{{ isset($produk) && $produk->foto ? asset('storage/' . $produk->foto) : '#' }}"
                            class="rounded-3 shadow-sm border"
                            style="width: 120px; height: 120px; object-fit: cover;">

                        <span class="badge position-absolute bottom-0 start-50 translate-middle-x mb-1 px-2 py-1" style="font-size: 0.7rem; background: var(--purple-soft); color: var(--purple-dark);">
                            Pratinjau
                        </span>
                    </div>
                </div>
            </div>

            @error('foto')
            <div class="text-danger small mt-1">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    {{-- KATEGORI PRODUK --}}
    <div class="col-12">
        <div class="p-4 form-card-section">
            <label class="form-label-custom">
                Kategori Produk <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-custom">
                <span class="input-group-text"><i class="bi bi-tags"></i></span>
                <select name="jenis"
                    id="jenisSelect2"
                    class="form-select form-control-custom @error('jenis') is-invalid @enderror"
                    required>
                    <option value="" disabled {{ old('jenis', $produk->jenis ?? '') == '' ? 'selected' : '' }}>
                        Pilih Kategori Produk
                    </option>
                    @foreach($jenisList as $jenis)
                    <option value="{{ $jenis->nama }}" {{ old('jenis', $produk->jenis ?? '') == $jenis->nama ? 'selected' : '' }}>
                        {{ $jenis->nama }}
                    </option>
                    @endforeach
                    @if(old('jenis') && !$jenisList->contains('nama', old('jenis')))
                    <option value="{{ old('jenis') }}" selected>{{ old('jenis') }}</option>
                    @endif
                </select>
            </div>
            @error('jenis')
            <div class="text-danger small mt-1">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    {{-- NAMA PRODUK --}}
    <div class="col-12">
        <div class="p-4 form-card-section">
            <label class="form-label-custom">
                Nama Produk <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-custom">
                <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                <input type="text"
                    name="name"
                    class="form-control form-control-custom @error('name') is-invalid @enderror"
                    placeholder="Masukkan nama produk"
                    value="{{ old('name', $produk->nama ?? '') }}"
                    required>
            </div>
            @error('name')
            <div class="text-danger small mt-1">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    {{-- HARGA BELI & HARGA JUAL --}}
    <div class="col-md-6">
        <div class="p-4 form-card-section h-100">
            <label class="form-label-custom">
                Harga Beli <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-custom mb-2">
                <span class="input-group-text">Rp</span>
                <input type="number"
                    id="hargaBeli"
                    name="purchase_price"
                    class="form-control form-control-custom @error('purchase_price') is-invalid @enderror"
                    placeholder="0"
                    value="{{ old('purchase_price', $produk->harga_beli ?? '') }}"
                    oninput="hitungMargin()"
                    required>
            </div>
            @error('purchase_price')
            <div class="text-danger small mt-1">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="p-4 form-card-section h-100">
            <label class="form-label-custom">
                Harga Jual <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-custom mb-2">
                <span class="input-group-text">Rp</span>
                <input type="number"
                    id="hargaJual"
                    name="selling_price"
                    class="form-control form-control-custom @error('selling_price') is-invalid @enderror"
                    placeholder="0"
                    value="{{ old('selling_price', $produk->harga_jual ?? '') }}"
                    oninput="hitungMargin()"
                    required>
            </div>

            {{-- ESTIMASI MARGIN KEUNTUNGAN --}}
            <div id="marginInfo" class="small fw-semibold text-muted">
                Estimasi Keuntungan: <span id="marginValue" class="text-success">Rp 0</span>
            </div>

            @error('selling_price')
            <div class="text-danger small mt-1">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>
    </div>

    {{-- STOK --}}
    <div class="col-12">
        <div class="p-4 form-card-section">
            <label class="form-label-custom">
                Stok Produk <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-custom">
                <span class="input-group-text"><i class="bi bi-stack"></i></span>
                <input type="number"
                    name="stock"
                    class="form-control form-control-custom @error('stock') is-invalid @enderror"
                    placeholder="0"
                    value="{{ old('stock', $produk->stok ?? '') }}"
                    required>
                <span class="input-group-text bg-light text-muted">Unit</span>
            </div>
            @error('stock')
            <div class="text-danger small mt-1">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
            </div>
            @enderror
        </div>
    </div>

</div>

{{-- TOMBOL AKSI --}}
<div class="d-flex align-items-center gap-3 mt-4">
    <button type="submit" class="btn btn-gradient-submit d-inline-flex align-items-center gap-2">
        <i class="bi bi-check-circle-fill"></i>
        <span>Simpan Produk</span>
    </button>

    <a href="{{ route('produk.index') }}" class="btn btn-soft-secondary d-inline-flex align-items-center gap-2">
        <i class="bi bi-arrow-left"></i>
        <span>Batal</span>
    </a>
</div>

{{-- JAVASCRIPT JQUERY & SELECT2 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Pratinjau gambar
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const container = document.getElementById('previewContainer');
        const placeholder = document.getElementById('uploadPlaceholder');

        const file = input.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            container.style.display = 'block';
            placeholder.style.display = 'none';
        }
    }

    // Kalkulasi Margin Keuntungan
    function hitungMargin() {
        const beli = parseFloat(document.getElementById('hargaBeli').value) || 0;
        const jual = parseFloat(document.getElementById('hargaJual').value) || 0;
        const profit = jual - beli;
        const marginElem = document.getElementById('marginValue');

        if (jual > 0) {
            if (profit >= 0) {
                marginElem.className = 'text-success fw-bold';
                marginElem.textContent = 'Rp ' + profit.toLocaleString('id-ID') + ' (Untung)';
            } else {
                marginElem.className = 'text-danger fw-bold';
                marginElem.textContent = 'Rp ' + profit.toLocaleString('id-ID') + ' (Rugi)';
            }
        } else {
            marginElem.className = 'text-muted';
            marginElem.textContent = 'Rp 0';
        }
    }

    $(document).ready(function() {
        hitungMargin();

        // Inisialisasi Select2
        $('#jenisSelect2').select2({
            theme: 'bootstrap-5',
            tags: false,
            placeholder: 'Pilih Kategori Produk',
            allowClear: true,
            minimumResultsForSearch: Infinity
        });
    });
</script>