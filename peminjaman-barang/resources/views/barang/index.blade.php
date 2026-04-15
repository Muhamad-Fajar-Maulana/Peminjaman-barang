@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Inventaris Barang</h5>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahBarang">
                  + Tambah Barang
                </button>
            </div>
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success mt-2">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger mt-2">
                        {{ session('error') }}
                    </div>
                @endif

                <table class="table table-striped table-hover mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th class="text-center">Stok</th>
                            <th class="text-center">Aksi</th> </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $b)
                        <tr>
                            <td><code>{{ $b->kode_barang }}</code></td>
                            <td>{{ $b->nama_barang }}</td>
                            <td>
                                <span class="badge bg-secondary">{{ $b->kategori->nama_kategori }}</span>
                            </td>
                            <td class="text-center">{{ $b->stok }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $b->id }}">
                                    Pinjam
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalPinjam{{ $b->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content text-start">
                                    <form action="{{ route('peminjaman.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="barang_id" value="{{ $b->id }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pinjam {{ $b->nama_barang }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Stok tersedia: <strong>{{ $b->stok }}</strong></p>
                                            <div class="mb-3">
                                                <label class="form-label">Jumlah Pinjam</label>
                                                <input type="number" name="jumlah_pinjam" class="form-control" max="{{ $b->stok }}" min="1" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tenggat Kembali</label>
                                                <input type="date" name="tenggat_waktu" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Konfirmasi Pinjam</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Belum ada data barang.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahBarang" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Form Tambah Barang Baru</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form action="{{ route('barang.store') }}" method="POST">
        @csrf 
        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Laptop Dell" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="" selected disabled>-- Pilih Kategori --</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Jumlah Stok Awal</label>
                <input type="number" name="stok" class="form-control" min="1" required>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection