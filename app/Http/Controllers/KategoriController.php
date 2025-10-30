<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori milik SaaS yang sedang login.
     */
    public function index()
    {
        // 1. Ambil data real
        // 4. Hanya ambil data yang 'id_saas'-nya sama dengan user yang login
        $kategoris = Kategori::where('id_saas', Auth::user()->id_saas)
                            ->latest()
                            ->get();
        
        return view('kategori', compact('kategoris'));
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        // 5. Validasi CRUD
        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama kategori unik per id_saas
                Rule::unique('kategoris')->where(function ($query) {
                    return $query->where('id_saas', Auth::user()->id_saas);
                }),
            ],
            'keterangan' => 'nullable|string',
        ]);

        // 4. Pengisian otomatis id_saas
        $validated['id_saas'] = Auth::user()->id_saas;

        Kategori::create($validated);

        // 'toast_success' adalah contoh, sesuaikan dengan setup notifikasi Anda
        return redirect()->route('kategori.index')->with('toast_success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui kategori yang ada di database.
     */
    public function update(Request $request, Kategori $kategori)
    {
        // 5. Pastikan user hanya bisa edit kategori miliknya
        if ($kategori->id_saas != Auth::user()->id_saas) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }

        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                // Pastikan unik, tapi abaikan ID kategori saat ini
                Rule::unique('kategoris')->where(function ($query) {
                    return $query->where('id_saas', Auth::user()->id_saas);
                })->ignore($kategori->id),
            ],
            'keterangan' => 'nullable|string',
        ]);

        $kategori->update($validated);

        return redirect()->route('kategori.index')->with('toast_success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(Kategori $kategori)
    {
        // 5. Pastikan user hanya bisa hapus kategori miliknya
        if ($kategori->id_saas != Auth::user()->id_saas) {
            abort(403, 'AKSI TIDAK DIIZINKAN');
        }
        
        $kategori->delete();

        return redirect()->route('kategori.index')->with('toast_success', 'Kategori berhasil dihapus.');
    }
}