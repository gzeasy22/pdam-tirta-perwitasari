@extends('layouts.admin')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.tarif.index') }}" class="btn btn-light rounded-circle shadow-sm me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h3 class="mb-0 text-gray-800 fw-bold">Tambah Tarif Baru</h3>
            </div>

            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.tarif.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-secondary">Kategori Golongan</label>
                                <input type="text" name="kategori_golongan" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: RUMAH TANGGA" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-secondary">Sub Golongan</label>
                                <input type="text" name="sub_golongan" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: Rumah Tangga B" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Minimal Pemakaian</label>
                            <div class="input-group input-group-lg shadow-sm rounded-3 overflow-hidden">
                                <input type="number" name="min_pakai" value="10" class="form-control border-0 bg-light" required>
                                <span class="input-group-text bg-white border-0 fw-bold text-secondary">m³</span>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">
                        <h6 class="fw-bold text-primary mb-3"><i class="fas fa-coins me-2"></i>Pengaturan Harga Progresif</h6>

                        <div class="row g-3 mb-5">
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-secondary fs-7">Blok 1 (0-10 m³)</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0 fw-bold">Rp</span>
                                    <input type="number" name="tarif_blok_1" class="form-control border-0 bg-light" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-secondary fs-7">Blok 2 (11-20 m³)</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0 fw-bold">Rp</span>
                                    <input type="number" name="tarif_blok_2" class="form-control border-0 bg-light" placeholder="0" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-secondary fs-7">Blok 3 (> 20 m³)</label>
                                <div class="input-group shadow-sm rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0 fw-bold">Rp</span>
                                    <input type="number" name="tarif_blok_3" class="form-control border-0 bg-light" placeholder="0" required>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm fw-bold">
                            <i class="fas fa-save me-2"></i> Simpan Tarif Baru
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection