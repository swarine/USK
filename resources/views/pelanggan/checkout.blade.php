@extends('layouts.pelanggan')
@section('title', 'Checkout')

@section('content')

<div style="max-width:720px; margin:0 auto;">

    <div style="margin-bottom:1.5rem;">
        <h1 style="font-family:'Playfair Display',serif; font-size:1.55rem; font-weight:700;">
            Checkout <span style="color:var(--pink);">Pesanan</span>
        </h1>
        <p style="color:var(--gray); font-size:0.875rem; margin-top:0.2rem;">Lengkapi data pengiriman dan pilih metode pembayaran</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
    @endif

    <form action="{{ route('pelanggan.checkout') }}" method="POST" id="checkout-form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="cart_data" id="cart-data-input" value="{{ $cartData }}">
        <input type="hidden" name="metode_pembayaran" id="metode-input" value="">

        {{-- ── RINGKASAN PESANAN ── --}}
        <div class="checkout-card" style="margin-bottom:1.25rem;">
            <div class="checkout-card__head">
                <i class="fas fa-shopping-bag" style="color:var(--pink);"></i>
                <span>Ringkasan Pesanan</span>
            </div>
            <div style="padding:1rem 1.25rem;">
                @foreach($items as $item)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.6rem 0; border-bottom:1px solid var(--border);">
                    <div style="display:flex; align-items:center; gap:0.75rem;">
                        @if($item['gambar'])
                            <img src="{{ asset('storage/' . $item['gambar']) }}"
                                 style="width:42px; height:42px; border-radius:8px; object-fit:cover; border:1px solid var(--border);">
                        @else
                            <div style="width:42px; height:42px; border-radius:8px; background:var(--pink-light); display:flex; align-items:center; justify-content:center; color:var(--pink-mid);">
                                <i class="fas fa-cube"></i>
                            </div>
                        @endif
                        <div>
                            <div style="font-weight:600; font-size:0.875rem;">{{ $item['nama'] }}</div>
                            <div style="font-size:0.78rem; color:var(--gray);">x{{ $item['qty'] }}</div>
                        </div>
                    </div>
                    <div style="font-weight:700; color:var(--pink); font-size:0.9rem;">
                        Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:0.85rem;">
                    <span style="font-weight:600;">Total</span>
                    <span style="font-size:1.2rem; font-weight:700; color:var(--pink); font-family:'Playfair Display',serif;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── DATA PENGIRIMAN ── --}}
        <div class="checkout-card" style="margin-bottom:1.25rem;">
            <div class="checkout-card__head">
                <i class="fas fa-map-marker-alt" style="color:var(--pink);"></i>
                <span>Data Pengiriman</span>
            </div>
            <div style="padding:1rem 1.25rem; display:flex; flex-direction:column; gap:0.9rem;">
                <div>
                    <label class="form-label">Nama Lengkap <span style="color:var(--pink);">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-user icon-left"></i>
                        <input type="text" name="nama_penerima" placeholder="Nama lengkap penerima"
                               value="{{ session('nama') }}" required>
                    </div>
                </div>
                <div>
                    <label class="form-label">Nomor Telepon <span style="color:var(--pink);">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-phone icon-left"></i>
                        <input type="text" name="nomor_telepon" placeholder="08xx-xxxx-xxxx" required>
                    </div>
                </div>
                <div>
                    <label class="form-label">Alamat Lengkap <span style="color:var(--pink);">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-map-marker-alt icon-left" style="top:0.85rem; transform:none;"></i>
                        <textarea name="alamat" rows="2" placeholder="Jl. ... No. ..., Kota" required
                                  style="padding-left:2.5rem; padding-top:0.65rem; width:100%; border:1.5px solid var(--border); border-radius:10px; font-size:0.875rem; font-family:inherit; background:#fffafd; color:var(--dark); outline:none; resize:none; transition:border-color 0.2s;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── METODE PEMBAYARAN ── --}}
        <div class="checkout-card" style="margin-bottom:1.5rem;">
            <div class="checkout-card__head">
                <i class="fas fa-credit-card" style="color:var(--pink);"></i>
                <span>Metode Pembayaran</span>
            </div>
            <div style="padding:1rem 1.25rem; display:flex; flex-direction:column; gap:0.75rem;">

                {{-- COD --}}
                <div class="payment-option" id="opt-cod" onclick="selectPayment('cod')">
                    <div style="display:flex; align-items:center; gap:1rem;">
                        <div class="payment-icon" style="background:#dcfce7; color:#16a34a;">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.9rem;">Cash on Delivery (COD)</div>
                            <div style="font-size:0.78rem; color:var(--gray);">Bayar tunai saat pesanan tiba</div>
                        </div>
                    </div>
                    <div class="payment-check" id="check-cod"><i class="fas fa-check"></i></div>
                </div>

                {{-- QRIS --}}
                <div class="payment-option" id="opt-qris" onclick="selectPayment('qris')">
                    <div style="display:flex; align-items:center; gap:1rem;">
                        <div class="payment-icon" style="background:#ede9fe; color:#7c3aed;">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.9rem;">QRIS</div>
                            <div style="font-size:0.78rem; color:var(--gray);">Scan QR dan upload bukti pembayaran</div>
                        </div>
                    </div>
                    <div class="payment-check" id="check-qris"><i class="fas fa-check"></i></div>
                </div>

                {{-- QR CODE + UPLOAD (muncul saat pilih QRIS) --}}
                <div id="qris-box" style="display:none; padding:1.25rem; background:var(--pink-light); border-radius:14px; border:1.5px dashed var(--pink-mid);">
                    <div style="text-align:center; margin-bottom:1.25rem;">
                        <p style="font-size:0.8rem; color:var(--gray); margin-bottom:0.75rem;">Scan QR code di bawah untuk membayar</p>
                        <img src="{{ asset('images/qr.png') }}"
                             style="width:180px; height:180px; border-radius:12px; border:3px solid var(--white); box-shadow:0 4px 16px rgba(233,30,140,0.15);">
                        <p style="font-size:0.75rem; color:var(--pink); font-weight:600; margin-top:0.75rem;">
                            Total: Rp {{ number_format($total, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- UPLOAD BUKTI --}}
                    <div style="background:var(--white); border-radius:12px; padding:1rem; border:1.5px solid var(--border);">
                        <label class="form-label" style="margin-bottom:0.5rem;">
                            <i class="fas fa-upload" style="color:var(--pink);"></i>
                            Upload Bukti Pembayaran <span style="color:var(--pink);">*</span>
                        </label>

                        <div class="upload-area" id="upload-area" onclick="document.getElementById('bukti-input').click()">
                            <div id="upload-placeholder">
                                <i class="fas fa-image" style="font-size:2rem; color:var(--pink-mid); display:block; margin-bottom:0.5rem;"></i>
                                <p style="font-size:0.8rem; color:var(--gray);">Klik untuk upload screenshot bukti transfer</p>
                                <p style="font-size:0.72rem; color:var(--pink-mid);">JPG, PNG, max 2MB</p>
                            </div>
                            <img id="preview-bukti" src="" style="display:none; max-width:100%; max-height:200px; border-radius:8px; object-fit:contain;">
                        </div>
                        <input type="file" id="bukti-input" name="bukti_pembayaran"
                               accept="image/jpg,image/jpeg,image/png"
                               style="display:none;" onchange="previewBukti(this)">
                        <p style="font-size:0.72rem; color:var(--gray); margin-top:0.4rem;">
                            <i class="fas fa-info-circle"></i> Pastikan bukti transfer terlihat jelas
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── SUBMIT ── --}}
        <button type="submit" class="btn-checkout-submit" id="btn-submit" disabled>
            <i class="fas fa-lock"></i> Konfirmasi Pesanan
        </button>

    </form>

</div>

@push('styles')
<style>
.alert { display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; border-radius:10px; font-size:0.875rem; margin-bottom:1.25rem; }
.alert-danger { background:#fee2e2; color:#dc2626; border:1px solid #fca5a5; }

.checkout-card { background:var(--white); border-radius:18px; border:1px solid var(--border); overflow:hidden; box-shadow:0 2px 12px rgba(233,30,140,0.06); }
.checkout-card__head { padding:0.85rem 1.25rem; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:0.6rem; font-weight:600; font-size:0.9rem; background:var(--bg); }

.form-label { display:block; font-size:0.8rem; font-weight:500; color:var(--dark); margin-bottom:0.35rem; }
.input-wrap { position:relative; }
.input-wrap i.icon-left { position:absolute; left:0.9rem; top:50%; transform:translateY(-50%); color:var(--pink-mid); font-size:0.9rem; pointer-events:none; }
.input-wrap input { width:100%; padding:0.65rem 0.9rem 0.65rem 2.5rem; border:1.5px solid var(--border); border-radius:10px; font-size:0.875rem; font-family:inherit; background:#fffafd; color:var(--dark); outline:none; transition:border-color 0.2s; }
.input-wrap input:focus { border-color:var(--pink); box-shadow:0 0 0 3px rgba(233,30,140,0.09); }
textarea:focus { border-color:var(--pink) !important; box-shadow:0 0 0 3px rgba(233,30,140,0.09); }

.payment-option { display:flex; align-items:center; justify-content:space-between; padding:0.85rem 1rem; border:1.5px solid var(--border); border-radius:12px; cursor:pointer; transition:all 0.18s; }
.payment-option:hover { border-color:var(--pink-mid); background:var(--pink-light); }
.payment-option.selected { border-color:var(--pink); background:var(--pink-light); }
.payment-icon { width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; flex-shrink:0; }
.payment-check { width:24px; height:24px; border-radius:50%; border:2px solid var(--border); display:flex; align-items:center; justify-content:center; font-size:0.7rem; color:transparent; transition:all 0.18s; }
.payment-check.active { background:var(--pink); border-color:var(--pink); color:var(--white); }

.upload-area { border:2px dashed var(--pink-mid); border-radius:10px; padding:1.5rem; text-align:center; cursor:pointer; transition:all 0.18s; background:var(--bg); }
.upload-area:hover { border-color:var(--pink); background:var(--pink-light); }

.btn-checkout-submit { width:100%; padding:0.85rem; background:var(--pink); color:var(--white); border:none; border-radius:12px; font-size:0.95rem; font-weight:600; font-family:inherit; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:0.5rem; }
.btn-checkout-submit:hover:not(:disabled) { background:var(--pink-dark); transform:translateY(-1px); box-shadow:0 6px 20px rgba(233,30,140,0.25); }
.btn-checkout-submit:disabled { background:var(--pink-mid); cursor:not-allowed; }
</style>
@endpush

@push('scripts')
<script>
let selectedMethod = '';
let buktiUploaded  = false;

function selectPayment(method) {
    selectedMethod = method;

    document.getElementById('opt-cod').classList.remove('selected');
    document.getElementById('opt-qris').classList.remove('selected');
    document.getElementById('check-cod').classList.remove('active');
    document.getElementById('check-qris').classList.remove('active');
    document.getElementById('qris-box').style.display = 'none';

    document.getElementById('opt-' + method).classList.add('selected');
    document.getElementById('check-' + method).classList.add('active');
    document.getElementById('metode-input').value = method;

    if (method === 'qris') {
        document.getElementById('qris-box').style.display = 'block';
        buktiUploaded = false;
        updateSubmitBtn();
    } else {
        document.getElementById('btn-submit').disabled = false;
    }
}

function previewBukti(input) {
    const file = input.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('upload-placeholder').style.display = 'none';
        const preview = document.getElementById('preview-bukti');
        preview.src = e.target.result;
        preview.style.display = 'block';
        buktiUploaded = true;
        updateSubmitBtn();
    };
    reader.readAsDataURL(file);
}

function updateSubmitBtn() {
    const btn = document.getElementById('btn-submit');
    if (selectedMethod === 'qris') {
        btn.disabled = !buktiUploaded;
    } else {
        btn.disabled = selectedMethod === '';
    }
}
</script>
@endpush

@endsection
