
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; font-size: 12px; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; font-size: 14px; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; text-align: right; }
    </style>
</head>
<body>
    <h2>Laporan Peminjaman Barang</h2>
    <p>Tanggal: {{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Barang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $i => $p)
                <tr>
                    <td style="text-align: center;">{{ $i + 1 }}</td>
                    <td>{{ $p->kode_peminjaman }}</td>
                    <td>{{ $p->nama_peminjam }}<br><small class="text-muted">{{ $p->jenis_peminjam }}</small></td>
                    <td>
                        {{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y') }}
                        @if($p->tanggal_kembali)
                            <br><small>Kembali: {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d/m/Y') }}</small>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ ucfirst($p->status) }}</td>
                    <td>
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($p->details as $d)
                                <li>{{ optional($d->barang)->nama_barang ?? 'Barang Dihapus' }} ({{ $d->jumlah }})</li>
                            @endforeach
                        </ul>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh: {{ Auth::user()->name }}
    </div>
</body>
</html>