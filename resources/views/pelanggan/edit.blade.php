@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1 class="page-title">Edit <span>Pelanggan</span></h1>
    <a href="{{ route('pelanggan.index') }}" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card" style="max-width:500px;">
    <div class="card-header">
        <h2><i class="fas fa-user-edit" style="color:var(--pink); margin-right:6px;"></i> Edit Data Pelanggan</h2>
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

        <form action="{{ route('pelanggan.update', $pelanggan->PelangganID) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Pelanggan <span style="color:var(--pink)">*</span></label>
                <input type="text" name="NamaPelanggan" value="{{ old('NamaPelanggan', $pelanggan->NamaPelanggan) }}" required>
            </div>
            <div class="form-group">
                <label>Email Pelanggan <span style="color:var(--pink)">*</span></label>
                <input type="text" name="EmailPelanggan" value="{{ old('EmailPelanggan', $pelanggan->EmailPelanggan) }}" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="NomorTelepon" value="{{ old('NomorTelepon', $pelanggan->NomorTelepon) }}" maxlength="15">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="Alamat" rows="3">{{ old('Alamat', $pelanggan->Alamat) }}</textarea>
            </div>
            <div style="display:flex; gap:0.6rem;">
                <button type="submit" class="btn btn-pink" style="flex:1; justify-content:center;">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
