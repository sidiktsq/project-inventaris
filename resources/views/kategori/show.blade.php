@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Detail Kategori</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <p class="form-control-static">{{ $kategori->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <p class="form-control-static">{{ $kategori->deskripsi ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <p>
                            @if($kategori->status)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection