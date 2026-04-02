@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1 class="page-title">Data <span>Pelanggan</span></h1>
</div>

@if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pelanggan as $p)
                <tr>
                    <td>{{ $p->PelangganID }}</td>

                    <td><strong>{{ $p->NamaPelanggan }}</strong></td>

                    <td style="max-width:200px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        {{ $p->EmailPelanggan ?? '-' }}
                    </td>

                    <td>{{ $p->Alamat ?? '-' }}</td>

                    <td>{{ $p->NomorTelepon ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:var(--gray); padding:2.5rem;">
                        <i class="fas fa-users-slash" style="font-size:1.8rem; display:block; margin-bottom:0.5rem; color:var(--pink-mid);"></i>
                        Belum ada pelanggan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
