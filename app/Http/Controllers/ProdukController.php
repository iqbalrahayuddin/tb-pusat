<?php

namespace App\Http\Controllers;

use App\Models\Produk;
// Supplier sudah dihapus di request sebelumnya
use App\Models\Kategori;
use App\Http\Requests\ProdukRequest; // Gunakan Form Request
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index()
    {
        $id_saas = Auth::user()->id_saas;

        // Ambil data yang relevan HANYA untuk id_saas pengguna
        $produks = Produk::where('id_saas', $id_saas)
                         ->with(['kategori']) // 'supplier' sudah dihapus
                         ->latest()
                         ->get();
        
        $kategoris = Kategori::where('id_saas', $id_saas)->orderBy('nama_kategori')->get();

        // 'suppliers' sudah dihapus
        return view('produk', compact('produks', 'kategoris'));
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(ProdukRequest $request)
    {
        // Validasi sudah ditangani oleh ProdukRequest

        // Gabungkan data tervalidasi dengan id_saas dari user
        $data = array_merge(
            $request->validated(),
            ['id_saas' => Auth::user()->id_saas]
        );

        Produk::create($data);

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan data produk (untuk JSON / AJAX).
     */
    public function show(Produk $produk)
    {
        // Otorisasi: Pastikan produk ini milik id_saas user
        if ($produk->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }

        // Kembalikan data sebagai JSON untuk diisi ke modal edit
        return response()->json($produk);
    }

    /**
     * Mengupdate produk.
     */
    public function update(ProdukRequest $request, Produk $produk)
    {
        // Otorisasi: Pastikan produk ini milik id_saas user
        if ($produk->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }

        // Validasi sudah ditangani oleh ProdukRequest
        $data = $request->validated();
        $produk->update($data);

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Produk $produk)
    {
        // Otorisasi: Pastikan produk ini milik id_saas user
        if ($produk->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak');
        }

        $produk->delete();

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}