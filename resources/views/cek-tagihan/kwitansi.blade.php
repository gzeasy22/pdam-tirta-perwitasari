<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Pembayaran</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; }
        .header { text-align: center; border-bottom: 2px dashed #333; padding-bottom: 15px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #1e3a8a; }
        .header p { margin: 5px 0 0 0; font-size: 12px; color: #555; }
        .status-lunas { text-align: center; font-size: 24px; font-weight: bold; color: #16a34a; border: 2px solid #16a34a; padding: 10px; width: 200px; margin: 0 auto 20px auto; transform: rotate(-5deg); letter-spacing: 2px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table td { padding: 8px; vertical-align: top; }
        .label { font-weight: bold; width: 30%; }
        .rincian { border-top: 2px solid #eee; margin-top: 20px; padding-top: 20px; }
        .rincian td { border-bottom: 1px solid #eee; }
        .total-row { font-size: 18px; font-weight: bold; background-color: #f8fafc; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #666; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>BUKTI PEMBAYARAN TAGIHAN AIR</h2>
        <p>Sistem Informasi Pengelolaan Air Bersih</p>
    </div>

    <div class="status-lunas">L U N A S</div>

    <table>
        <tr>
            <td class="label">ID Transaksi / Order</td>
            <td>: {{ $tagihan->order_id ?? 'Manual/Loket' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Pembayaran</td>
            <td>: {{ $tagihan->updated_at->format('d F Y - H:i:s') }}</td>
        </tr>
        <tr>
            <td class="label">Nama Pelanggan</td>
            <td>: {{ $tagihan->pelanggan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">Nomor Sambungan</td>
            <td>: {{ $tagihan->pelanggan->nomor_pelanggan }}</td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td>: {{ $tagihan->pelanggan->alamat_lengkap }}</td>
        </tr>
    </table>

    <table class="rincian">
        <tr>
            <td class="label">Tagihan Bulan</td>
            <td style="text-align: right;">{{ \Carbon\Carbon::parse($tagihan->bulan_tahun)->format('F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Stand Meter</td>
            <td style="text-align: right;">{{ $tagihan->meteran_awal }} - {{ $tagihan->meteran_akhir }} (Pemakaian: {{ $tagihan->pemakaian }} m³)</td>
        </tr>
        <tr>
            <td class="label">Metode Pembayaran</td>
            <td style="text-align: right;">{{ strtoupper($tagihan->metode_pembayaran ?? 'CASH / LOKET') }}</td>
        </tr>
        <tr class="total-row">
            <td class="label" style="padding-top: 15px;">TOTAL DIBAYAR</td>
            <td style="text-align: right; padding-top: 15px;">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Terima kasih atas pembayaran Anda.</p>
        <p>Struk ini adalah bukti pembayaran yang sah dan diterbitkan secara otomatis oleh sistem.</p>
    </div>
</div>

</body>
</html>