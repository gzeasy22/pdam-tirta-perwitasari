@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 text-gray-800 fw-bold">
            <i class="fas fa-tags text-primary me-2"></i> Kelola Tarif Air
        </h3>
        <a href="{{ route('admin.tarif.create') }}" class="btn btn-primary rounded-pill shadow-sm px-4">
            <i class="fas fa-plus me-2"></i> Tambah Tarif
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-secondary fw-semibold py-3 px-4 border-0">Golongan</th>
                            <th class="text-secondary fw-semibold py-3 border-0">Min. Pakai</th>
                            <th class="text-secondary fw-semibold py-3 text-center border-0">Blok I (0-10 m³)</th>
                            <th class="text-secondary fw-semibold py-3 text-center border-0">Blok II (11-20 m³)</th>
                            <th class="text-secondary fw-semibold py-3 text-center border-0">Blok III (>20 m³)</th>
                            <th class="text-secondary fw-semibold py-3 text-center border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tarifs as $t)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="d-block fw-bold text-dark fs-6">{{ $t->sub_golongan }}</span>
                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2">{{ $t->kategori_golongan }}</span>
                            </td>
                            <td><span class="badge bg-secondary rounded-pill px-3">{{ $t->min_pakai }} m³</span></td>
                            <td class="text-center text-dark fw-medium">Rp {{ number_format($t->tarif_blok_1, 0, ',', '.') }}</td>
                            <td class="text-center text-dark fw-medium">Rp {{ number_format($t->tarif_blok_2, 0, ',', '.') }}</td>
                            <td class="text-center text-dark fw-medium">Rp {{ number_format($t->tarif_blok_3, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.tarif.edit', $t->id) }}" class="btn btn-sm btn-light text-warning rounded-circle shadow-sm me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.tarif.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau menghapus tarif ini secara permanen?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-light text-danger rounded-circle shadow-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fs-2 mb-3 text-light"></i><br>
                                Belum ada data tarif air yang ditambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div><div class="d-flex justify-content-end px-4 py-3 border-top">
                {{ $tarifs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection