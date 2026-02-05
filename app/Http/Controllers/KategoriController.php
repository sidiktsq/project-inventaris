<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $kategoris = Kategori::all();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status'    => 'nullable|string',
        ]);

        Kategori::create($request->all());
        return redirect()->route('kategori.index')->with('success', 'Data berhasil ditambah');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'   => 'required',
            'status' => 'required|in:0,1',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'status'    => $request->status, // Mengambil input dari select
        ]);

        return redirect()->route('kategori.index')->with('success', 'Data berhasil diubah');
    }


    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('kategori.index')->with('success', 'Data berhasil dihapus');
    }
}