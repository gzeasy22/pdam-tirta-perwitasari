@extends('layouts.admin') 

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>📝 Validasi Balik Nama</h2>
    </div>

    <div style="display: flex; gap: 10px; margin-bottom: 20px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; overflow-x: auto;">
        <a href="{{ route('admin.balik-nama', ['tab' => 'Pending']) }}" style="text-decoration: none; padding: 8px 15px; font-weight: bold; border-radius: 4px; white-space: nowrap; {{ $tab == 'Pending' ? 'background: #0ea5e9; color: white;' : 'background: #f1f5f9; color: #475569;' }}">
            ⏳ Pending ({{ $countPending }})
        </a>
        <a href="{{ route('admin.balik-nama', ['tab' => 'Menunggu Pembayaran']) }}" style="text-decoration: none; padding: 8px 15px; font-weight: bold; border-radius: 4px; white-space: nowrap; {{ $tab == 'Menunggu Pembayaran' ? 'background: #f59e0b; color: white;' : 'background: #f1f5f9; color: #475569;' }}">
            💳 Menunggu Pembayaran ({{ $countMenunggu }})
        </a>
        <a href="{{ route('admin.balik-nama', ['tab' => 'Selesai']) }}" style="text-decoration: none; padding: 8px 15px; font-weight: bold; border-radius: 4px; white-space: nowrap; {{ $tab == 'Selesai' ? 'background: #10b981; color: white;' : 'background: #f1f5f9; color: #475569;' }}">
            ✅ Selesai ({{ $countSelesai }})
        </a>
        <a href="{{ route('admin.balik-nama', ['tab' => 'Rejected']) }}" style="text-decoration: none; padding: 8px 15px; font-weight: bold; border-radius: 4px; white-space: nowrap; {{ $tab == 'Rejected' ? 'background: #ef4444; color: white;' : 'background: #f1f5f9; color: #475569;' }}">
            ❌ Ditolak ({{ $countRejected }})
        </a>
    </div>

    <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
        <div style="display: flex; border: 1px solid #cbd5e1; border-radius: 4px; overflow: hidden;">
            <input type="text" placeholder="Cari No. Pelanggan / Nama..." style="padding: 8px 12px; border: none; outline: none; width: 250px;">
            <button style="background: #3b82f6; color: white; border: none; padding: 8px 15px; cursor: pointer; font-weight: bold;"><i class="fas fa-search"></i> Cari</button>
        </div>
    </div>

    @forelse($groupedPengajuan as $kecamatan => $rayons)
        @php $idKec = $loop->iteration; @endphp
        
        <div onclick="toggleLaci('isi-kec-{{ $idKec }}', 'icon-kec-{{ $idKec }}')" style="cursor: pointer; background-color: #1e293b; color: white; border-radius: 6px; padding: 12px 15px; margin-bottom: 10px; margin-top: 20px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="font-weight: bold; font-size: 15px;">
                <i class="fas fa-building" style="margin-right: 8px; color: #94a3b8;"></i> Kecamatan: {{ $kecamatan }}
            </div>
            <span style="background: #3b82f6; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                {{ $rayons->flatten()->count() }} Warga <i id="icon-kec-{{ $idKec }}" class="fas fa-chevron-down" style="margin-left: 5px; transition: 0.3s;"></i>
            </span>
        </div>

        <div id="isi-kec-{{ $idKec }}" style="display: none;">
            @foreach($rayons as $rayon => $items)
                @php $idRayon = $idKec . '-' . $loop->iteration; @endphp
                
                <div onclick="toggleLaci('isi-ray-{{ $idRayon }}', 'icon-ray-{{ $idRayon }}')" style="cursor: pointer; background-color: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; padding: 10px 15px; margin-bottom: 10px; margin-left: 20px; border-radius: 4px; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-weight: bold; font-size: 14px;">
                        <i class="fas fa-map-marker-alt" style="margin-right: 8px; color: #10b981;"></i> Area Rayon: {{ $rayon }}
                    </div>
                    <span style="background: #10b981; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">
                        {{ $items->count() }} Warga <i id="icon-ray-{{ $idRayon }}" class="fas fa-chevron-down" style="margin-left: 5px; transition: 0.3s;"></i>
                    </span>
                </div>

                <div id="isi-ray-{{ $idRayon }}" style="display: none; margin-left: 20px; margin-bottom: 25px; border: 1px solid #e2e8f0; border-radius: 6px; overflow: hidden;">
                    <table style="width: 100%; text-align: left; border-collapse: collapse; background: white;">
                        <thead>
                            <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <th style="padding: 12px; font-size: 13px; color: #475569;">No. Pelanggan</th>
                                <th style="padding: 12px; font-size: 13px; color: #475569;">Nama Lama -> Baru</th>
                                <th style="padding: 12px; font-size: 13px; color: #475569;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 12px;"><strong>{{ $item->nomor_pelanggan }}</strong></td>
                                <td style="padding: 12px;">
                                    <span style="color: #ef4444; text-decoration: line-through; font-size: 13px;">{{ $item->nama_lama }}</span> <br>
                                    <span style="color: #10b981; font-weight: bold; font-size: 14px;">{{ $item->nama_baru }}</span><br>
                                    <span style="font-size: 11px; color: #64748b;">NIK: {{ $item->nik_baru }}</span>
                                </td>
                                <td style="padding: 12px;">
                                    @if($item->status == 'Pending')
                                        @php
                                            $fileKtp = basename($item->foto_ktp_baru);
                                            $fileBukti = basename($item->foto_bukti_kepemilikan);
                                            $urlKtp = route('dokumen.rahasia', ['jenis' => 'berkas_ktp', 'nama_file' => $fileKtp]);
                                            $urlBukti = route('dokumen.rahasia', ['jenis' => 'berkas_kepemilikan', 'nama_file' => $fileBukti]);
                                        @endphp
                                        <button onclick="bukaModalValidasi('{{ $item->id }}', '{{ $item->nik_baru }}', '{{ $urlKtp }}', '{{ $urlBukti }}')" style="cursor:pointer; padding: 8px 14px; background: #0ea5e9; color: white; border: none; border-radius: 4px; font-weight: bold;">
                                            🔍 Cek Berkas
                                        </button>
                                    @else
                                        <span style="padding: 5px 10px; border-radius: 4px; font-weight: bold; color: white; background: {{ $item->status == 'Approved' ? '#10b981' : '#ef4444' }}; font-size: 12px;">
                                            {{ $item->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

    @empty
        <div style="text-align: center; padding: 40px; background: white; border: 1px dashed #cbd5e1; border-radius: 6px; color: #64748b;">
            <i class="fas fa-folder-open" style="font-size: 30px; margin-bottom: 10px; color: #cbd5e1;"></i><br>
            Tidak ada data di antrean ini.
        </div>
    @endforelse
</div>

<div class="modal-gaib-overlay" id="modalValidasi" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(0, 0, 0, 0.6); z-index: 9999; display: none; justify-content: center; align-items: center; opacity: 0; transition: opacity 0.3s ease;">
    <div class="modal-gaib-box" style="background: white; border-radius: 12px; width: 500px; max-width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.3); overflow: hidden; font-family: 'Segoe UI', sans-serif;">
        <div class="modal-gaib-header" style="background: #0ea5e9; color: white; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center; font-weight: bold; font-size: 16px;">
            <span>🔍 Validasi Berkas</span>
            <button type="button" class="modal-gaib-close" onclick="document.getElementById('modalValidasi').classList.remove('tampil'); setTimeout(() => document.getElementById('modalValidasi').style.display = 'none', 300);" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer; line-height: 1;">&times;</button>
        </div>
        <div class="modal-gaib-body" style="padding: 25px;">
            <div style="background: #f1f5f9; padding: 10px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #0ea5e9;">
                <span style="font-size: 14px; color: #64748b;">NIK KTP Baru:</span><br>
                <strong id="textNik" style="font-size: 18px; color: #0f172a;"></strong>
            </div>

            <div style="margin-bottom: 25px; display: flex; flex-direction: column; gap: 10px;">
                <span style="font-size: 12px; font-weight: bold; color: #64748b; text-transform: uppercase;">Berkas Dokumen</span>
                
                <a id="btnBukaKtp" href="#" target="_blank" style="display: block; padding: 10px 15px; background: #0ea5e9; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; text-align: center;">
                    <i class="fas fa-eye"></i> Buka Foto KTP
                </a>

                <a id="btnBukaBukti" href="#" target="_blank" style="display: block; padding: 10px 15px; background: #8b5cf6; color: white; text-decoration: none; border-radius: 4px; font-weight: bold; text-align: center;">
                    <i class="fas fa-eye"></i> Buka Bukti Kepemilikan
                </a>
            </div>
            
            <div id="wadahTombolAwal" style="display: flex; gap: 10px;">
                <button type="button" onclick="tampilFormTolak()" style="flex: 1; padding: 10px; background: #ef4444; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">❌ Tolak</button>

                <form id="formSetuju" method="POST" action="" style="flex: 1;">
                    @csrf
                    <button type="submit" onclick="return confirm('Yakin validasi berkas ini? Warga akan ditagih biaya Rp 27.500 sebelum data kepemilikan resmi diubah otomatis oleh sistem.')" style="width: 100%; padding: 10px; background: #10b981; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">✅ ACC & Tagih Warga</button>
                </form>
            </div>

            <div id="wadahFormTolak" style="display: none; background: #fee2e2; padding: 15px; border-radius: 6px; border: 1px solid #fca5a5;">
                <span style="font-size: 13px; font-weight: bold; color: #991b1b; display: block; margin-bottom: 8px;">Berikan Alasan Penolakan:</span>
                
                <form id="formTolak" method="POST" action="">
                    @csrf
                    <textarea name="alasan_penolakan" id="inputAlasan" rows="3" placeholder="Contoh: Foto KTP buram, nama tidak sesuai dengan bukti..." style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #f87171; outline: none; font-family: inherit; margin-bottom: 10px; resize: vertical;" required></textarea>
                    
                    <div style="display: flex; gap: 10px;">
                        <button type="button" onclick="batalTolak()" style="flex: 1; padding: 10px; background: #94a3b8; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">⬅ Batal</button>
                        <button type="submit" style="flex: 1; padding: 10px; background: #ef4444; color: white; border: none; border-radius: 4px; font-weight: bold; cursor: pointer;">Kirim Penolakan 🚀</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JS BUKA TUTUP LACI
    function toggleLaci(laciId, iconId) {
        let laci = document.getElementById(laciId);
        let icon = document.getElementById(iconId);
        
        if (laci.style.display === "none") {
            laci.style.display = "block";
            icon.style.transform = "rotate(180deg)";
        } else {
            laci.style.display = "none";
            icon.style.transform = "rotate(0deg)";
        }
    }

    // JS MODAL GAIB
    // JS MODAL GAIB
    function bukaModalValidasi(id, nikBaru, ktpUrl, buktiUrl) {
        // Reset tampilan modal ke kondisi awal (Tombol ACC/Tolak muncul, form alasan sembunyi)
        document.getElementById('wadahTombolAwal').style.display = 'flex';
        document.getElementById('wadahFormTolak').style.display = 'none';
        document.getElementById('inputAlasan').value = ''; // Kosongin isi textareanya

        // Isi data modal
        document.getElementById('textNik').innerText = nikBaru;
        document.getElementById('btnBukaKtp').href = ktpUrl;
        document.getElementById('btnBukaBukti').href = buktiUrl;
        
        // Ganti URL action form
        document.getElementById('formSetuju').action = `/admin/validasi-balik-nama/${id}/approve`;
        document.getElementById('formTolak').action = `/admin/validasi-balik-nama/${id}/reject`;

        // Tunjukin modalnya
        let modal = document.getElementById('modalValidasi');
        modal.style.display = 'flex';
        setTimeout(() => { modal.style.opacity = '1'; modal.classList.add('tampil'); }, 10);
    }

    // JS BUAT GANTI TOMBOL JADI FORM PENOLAKAN
    function tampilFormTolak() {
        document.getElementById('wadahTombolAwal').style.display = 'none';
        document.getElementById('wadahFormTolak').style.display = 'block';
    }

    // JS BUAT BATALIN PENOLAKAN (KEMBALI KE TOMBOL AWAL)
    function batalTolak() {
        document.getElementById('wadahFormTolak').style.display = 'none';
        document.getElementById('wadahTombolAwal').style.display = 'flex';
    }

    // JS PROMPT PENOLAKAN
    function tolakPengajuan() {
        let alasan = prompt("Masukkan alasan penolakan (Misal: KTP tidak jelas / Beda nama):");
        if (alasan != null && alasan.trim() != "") {
            document.getElementById('inputAlasan').value = alasan;
            document.getElementById('formTolak').submit();
        }
    }
</script>
@endsection