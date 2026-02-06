<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'details.barang'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $barangs      = Barang::where('jumlah', '>', 0)->get();
        $date         = date('Ymd');
        $lastRecord   = Peminjaman::whereDate('created_at', date('Y-m-d'))->latest()->first();
        $sequence     = $lastRecord ? (int) substr($lastRecord->kode_peminjaman, -3) + 1 : 1;
        $kodeOtomatis = 'PMJ-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return view('peminjaman.create', compact('barangs', 'kodeOtomatis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peminjam'   => 'required',
            'jenis_peminjam'  => 'required',
            'tanggal_pinjam'  => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'barang_id'       => 'required|array',
            'barang_id.*'     => 'required|exists:barang,id',
            'jumlah'          => 'required|array',
            'jumlah.*'        => 'required|numeric|min:1',
        ]);

        // Validasi stok barang
        foreach ($request->barang_id as $index => $barang_id) {
            $barang = Barang::find($barang_id);
            $jumlah_pinjam = $request->jumlah[$index];
            if ($barang->jumlah < $jumlah_pinjam) {
                return back()->withInput()->with('error', "Stok barang '{$barang->nama_barang}' tidak mencukupi. Tersedia: {$barang->jumlah}, Diminta: {$jumlah_pinjam}");
            }
        }

        try {
            DB::transaction(function () use ($request) {
                $peminjaman = Peminjaman::create([
                    'kode_peminjaman' => $request->kode_peminjaman,
                    'nama_peminjam'   => $request->nama_peminjam,
                    'jenis_peminjam'  => $request->jenis_peminjam,
                    'tanggal_pinjam'  => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status'          => 'dipinjam',
                    'user_id'         => Auth::id(),
                ]);

                // Loop through each barang
                foreach ($request->barang_id as $index => $barang_id) {
                    DetailPeminjaman::create([
                        'peminjaman_id'   => $peminjaman->id,
                        'barang_id'       => $barang_id,
                        'jumlah'          => $request->jumlah[$index],
                        'kondisi_sebelum' => 'Baik',
                    ]);

                    // Update stock
                    $barang = Barang::find($barang_id);
                    $barang->decrement('jumlah', $request->jumlah[$index]);
                }
            });

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan peminjaman: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::with('details.barang')->findOrFail($id);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        // Pastikan nama field di validasi sama dengan nama di tag <input> atau <select>
        $request->validate([
            'nama_peminjam'   => 'required',
            'status'          => 'required',
            'tanggal_kembali' => 'required|date',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $peminjaman = Peminjaman::findOrFail($id);
                $oldStatus  = $peminjaman->status;

                // 1. Update Tabel Peminjaman
                $peminjaman->update([
                    'nama_peminjam'   => $request->nama_peminjam,
                    'status'          => $request->status,
                    'tanggal_kembali' => $request->tanggal_kembali,
                ]);

                // 2. Update Tabel Detail (Kondisi Sesudah)
                $detail = DetailPeminjaman::where('peminjaman_id', $id)->first();
                if ($detail) {
                    $detail->update([
                        'kondisi_sesudah' => $request->kondisi_sesudah,
                    ]);

                    // 3. Logika Stok Otomatis
                    if ($oldStatus !== 'dikembalikan' && $request->status === 'dikembalikan') {
                        Barang::find($detail->barang_id)->increment('jumlah', $detail->jumlah);
                    } elseif ($oldStatus === 'dikembalikan' && $request->status !== 'dikembalikan') {
                        Barang::find($detail->barang_id)->decrement('jumlah', $detail->jumlah);
                    }
                }
            });

            return redirect()->route('peminjaman.index')->with('success', 'Data berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update: ' . $e->getMessage());
        }
    }

  
    public function show($id)
{
    $peminjaman = Peminjaman::with(['details.barang', 'user'])
        ->findOrFail($id);
        
    return view('peminjaman.show', compact('peminjaman'));
}
   

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        foreach ($peminjaman->details as $detail) {
            Barang::find($detail->barang_id)->increment('jumlah', $detail->jumlah);
        }
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Data dihapus.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::with('details')->findOrFail($id);

        if ($peminjaman->status == 'dikembalikan') {
            return back()->with('error', 'Barang sudah dikembalikan sebelumnya.');
        }

        try {
            DB::transaction(function () use ($peminjaman) {
                // Update status peminjaman
                $peminjaman->update(['status' => 'dikembalikan']);

                // Kembalikan stok
                foreach ($peminjaman->details as $detail) {
                    Barang::find($detail->barang_id)->increment('jumlah', $detail->jumlah);
                }
            });

            return redirect()->route('peminjaman.index')->with('success', 'Barang berhasil dikembalikan dan stok telah diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengembalikan barang: ' . $e->getMessage());
        }
    }

     public function exportExcel()
    {
        return Excel::download(new PeminjamanExport, 'laporan-peminjaman-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $peminjaman = Peminjaman::with(['details.barang', 'user'])->latest()->get();
        $pdf = Pdf::loadView('peminjaman.pdf', compact('peminjaman'));
        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }

}