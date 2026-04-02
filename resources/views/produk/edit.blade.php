@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1 class="page-title">Edit <span>Produk</span></h1>
    <a href="{{ route('produk.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width:480px;">
    <div class="card-header">
        <h2><i class="fas fa-box" style="color:var(--pink); margin-right:6px;"></i> Edit Data Produk</h2>
    </div>
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin:0; padding-left:1rem;">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('produk.update', $produk->ProdukID) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Produk <span style="color:var(--pink)">*</span></label>
                <input type="text" name="NamaProduk" value="{{ old('NamaProduk', $produk->NamaProduk) }}" required>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="form-group">
                    <label>Harga (Rp) <span style="color:var(--pink)">*</span></label>
                    <input type="number" name="Harga" value="{{ old('Harga', $produk->Harga) }}" min="0" required>
                </div>
                <div class="form-group">
                    <label>Stok <span style="color:var(--pink)">*</span></label>
                    <input type="number" name="Stok" value="{{ old('Stok', $produk->Stok) }}" min="0" required>
                </div>
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <div class="upload-area" onclick="document.getElementById('Gambar').click()">
                    @if($produk->Gambar)
                        <img id="preview-img" src="{{ asset('storage/' . $produk->Gambar) }}"
                             alt="Foto" style="max-height:160px; border-radius:8px; object-fit:contain;">
                        <div id="upload-placeholder" style="display:none;">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik untuk ganti foto</p>
                        </div>
                    @else
                        <div id="upload-placeholder">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik untuk pilih foto</p>
                            <small>JPG, PNG, WEBP — maks 2MB</small>
                        </div>
                        <img id="preview-img" src="" style="display:none; max-height:160px; border-radius:8px; object-fit:contain;">
                    @endif
                </div>
                <input type="file" name="Gambar" id="Gambar" accept="image/*"
                       style="display:none" onchange="previewImage(this)">
                @if($produk->Gambar)
                    <small style="color:var(--gray); font-size:0.75rem;">Biarkan kosong jika tidak ingin ganti foto.</small>
                @endif
            </div>

            <div style="display:flex; gap:0.6rem; margin-top:0.25rem;">
                <button type="submit" class="btn btn-pink" style="flex:1; justify-content:center;">
                    <i class="fas fa-save"></i> Update Produk
                </button>
                <a href="{{ route('produk.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .upload-area {
        border: 2px dashed var(--pink-mid);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        background: var(--pink-light);
        transition: all 0.2s;
        min-height: 110px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .upload-area:hover { border-color: var(--pink); background: #fce4f3; }
    .upload-area i { font-size: 2rem; color: var(--pink); display: block; margin-bottom: 0.4rem; }
    .upload-area p { font-size: 0.875rem; font-weight: 500; color: var(--dark); margin-bottom: 0.2rem; }
    .upload-area small { color: var(--gray); font-size: 0.75rem; }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        const placeholder = document.getElementById('upload-placeholder');
        const preview     = document.getElementById('preview-img');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush