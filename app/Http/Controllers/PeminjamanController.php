<?php
namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'barang_id'       => 'required',
            'jumlah'          => 'required|numeric|min:1',
        ]);

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

                DetailPeminjaman::create([
                    'peminjaman_id'   => $peminjaman->id,
                    'barang_id'       => $request->barang_id,
                    'jumlah'          => $request->jumlah,
                    'kondisi_sebelum' => $request->kondisi_sebelum ?? 'Baik',
                ]);

                $barang = Barang::find($request->barang_id);
                $barang->decrement('jumlah', $request->jumlah);
            });

            return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
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
    $peminjaman = Peminjaman::with(['barang', 'user', 'pengembalian'])
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
}