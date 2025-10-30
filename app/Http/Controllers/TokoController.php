<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk mengambil id_saas
use Illuminate\Validation\Rule;

class TokoController extends Controller
{
    /**
     * 1. Menampilkan data realtime (hanya milik user's saas)
     */
    public function index()
    {
        $id_saas_user = Auth::user()->id_saas;
        $tokos = Toko::where('id_saas', $id_saas_user)->get();
        
        // 6. Nama view adalah 'toko.blade.php'
        return view('toko', compact('tokos'));
    }

    /**
     * 4. Menyimpan data (Create)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'nomor_telfon' => 'nullable|string|max:20',
        ]);

        // 5. Pengisian otomatis id_saas
        $validatedData['id_saas'] = Auth::user()->id_saas;

        Toko::create($validatedData);

        return redirect()->route('toko.index')->with('success', 'Data toko berhasil ditambahkan.');
    }

    /**
     * (Tidak digunakan di view ini, tapi ada di resource)
     */
    public function show(Toko $toko)
    {
        // Opsional: Cek otorisasi
        if ($toko->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }
        // return view('toko-show', compact('toko'));
    }

    /**
     * (Tidak digunakan di view ini, tapi ada di resource)
     */
    public function edit(Toko $toko)
    {
         // Opsional: Cek otorisasi
        if ($toko->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }
        // return view('toko-edit', compact('toko'));
    }

    /**
     * 4. Mengupdate data (Update)
     */
    public function update(Request $request, Toko $toko)
    {
        // Keamanan: Pastikan user hanya bisa mengedit toko miliknya
        if ($toko->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }

        $validatedData = $request->validate([
            'nama_toko' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'penanggung_jawab' => 'required|string|max:255',
            'nomor_telfon' => 'nullable|string|max:20',
        ]);

        // id_saas tidak perlu diupdate karena sudah dicek
        $toko->update($validatedData);

        return redirect()->route('toko.index')->with('success', 'Data toko berhasil diperbarui.');
    }

    /**
     * 4. Menghapus data (Delete)
     */
    public function destroy(Toko $toko)
    {
        // Keamanan: Pastikan user hanya bisa menghapus toko miliknya
        if ($toko->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }

        $toko->delete();

        return redirect()->route('toko.index')->with('success', 'Data toko berhasil dihapus.');
    }
}