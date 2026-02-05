<?php

namespace App\Http\Controllers;

use App\Models\Barang;   // Pastikan ini ada
use App\Models\Kategori; // Ini yang menyebabkan error tadi
use App\Models\Lokasi;   // Import juga model Lokasi
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
  public function index() {
    $barang = Barang::with('lokasi')->paginate(10);
    return view('barang.index', compact('barang'));
}

 public function create()
{
    $kategoris = \App\Models\Kategori::all();
    $lokasis = \App\Models\Lokasi::all();
    $kode_barang = 'BRG-' . date('Ymd') . '-' . strtoupper(Str::random(4));
    return view('barang.create', compact('kategoris', 'lokasis', 'kode_barang'));
}

   public function store(Request $request)
{
    $request->validate([
        'kode_barang' => 'required|unique:barang',
        'nama_barang' => 'required|string|max:255',
        'kategori_id' => 'required|exists:kategori,id',
        'lokasi_id'   => 'required|exists:lokasi,id',
        'kondisi'     => 'required|in:baik,rusak_ringan,rusak_berat,hilang',
        'jumlah'      => 'required|numeric|min:1',
        'satuan'      => 'required|string|max:20',
        'tanggal_beli'=> 'required|date',
        'harga'       => 'required|numeric|min:0',
        'deskripsi'   => 'nullable|string',
        'foto'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    try {
        $data = $request->except('_token');
        
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('uploads/barang', 'public');
        }

        Barang::create($data);
        
        return redirect()->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan!');
            
    } catch (\Exception $e) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal menambahkan barang: ' . $e->getMessage());
    }
}

    public function edit(Barang $barang)
{
    $kategoris = Kategori::all();
    $lokasis = Lokasi::all();
    return view('barang.edit', compact('barang', 'kategoris', 'lokasis'));
}

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        $request->validate([
            'nama_barang' => 'required',
            'kode_barang' => 'required|unique:barang,kode_barang,'.$id,
            'kategori_id' => 'required',
            'lokasi_id'   => 'required',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui');
    }

    public function show($id)
    {
        $barang = Barang::with(['kategori', 'lokasi'])->findOrFail($id);
        return view('barang.show', compact('barang'));
    }

    public function destroy($id) {
        Barang::destroy($id);
        return redirect()->route('barang.index')->with('success', 'Data dihapus!');
    }

}
