<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalBarang = \App\Models\Barang::count();
        $peminjamanAktif = \App\Models\Peminjaman::where('status', 'dipinjam')->count();
        $totalKategori = \App\Models\Kategori::count();
        $totalLokasi = \App\Models\Lokasi::count();
        $peminjamanTerbaru = \App\Models\Peminjaman::latest()->take(5)->get();
        $barangStokRendah = \App\Models\Barang::where('jumlah', '<', 5)->count();

        return view('dashboard.index', compact(
            'totalBarang',
            'peminjamanAktif',
            'totalKategori',
            'totalLokasi',
            'peminjamanTerbaru',
            'barangStokRendah'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
