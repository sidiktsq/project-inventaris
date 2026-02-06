@extends('layouts.dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Kategori /</span> Edit Kategori
    </h4>

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Form Edit Kategori</h5>
                    <small class="text-muted float-end">Ubah informasi kategori barang</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                value="{{ old('nama', $kategori->nama) }}" placeholder="Masukkan nama kategori" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" name="deskripsi" 
                                rows="3" placeholder="Masukkan deskripsi singkat">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                            <a href="{{ route('kategori.index') }}" class="btn btn-label-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection