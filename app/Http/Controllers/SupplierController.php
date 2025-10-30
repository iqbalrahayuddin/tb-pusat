<?php
// app/Http/Controllers/SupplierController.php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    /**
     * Menampilkan daftar supplier milik user.
     */
    public function index()
    {
        $id_saas = Auth::user()->id_saas;
        $suppliers = Supplier::where('id_saas', $id_saas)->latest()->get();
        return view('supplier', compact('suppliers'));
    }

    /**
     * Menyimpan supplier baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input (tanpa 'produk')
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            // 'produk' => 'nullable|string|max:255', // <-- DIHAPUS
            'email' => 'nullable|email|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
        ]);

        $validatedData['id_saas'] = Auth::user()->id_saas;
        Supplier::create($validatedData);

        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil ditambahkan.');
    }

    /**
     * Update data supplier.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input (tanpa 'produk')
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            // 'produk' => 'nullable|string|max:255', // <-- DIHAPUS
            'email' => 'nullable|email|max:255',
            'nomor_hp' => 'nullable|string|max:20',
            'website' => 'nullable|string|max:255',
        ]);

        $supplier = Supplier::where('id', $id)
                            ->where('id_saas', Auth::user()->id_saas)
                            ->firstOrFail(); 

        $supplier->update($validatedData);

        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil diperbarui.');
    }

    /**
     * Hapus data supplier.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::where('id', $id)
                            ->where('id_saas', Auth::user()->id_saas)
                            ->firstOrFail(); 

        $supplier->delete();

        return redirect()->route('supplier.index')
                         ->with('success', 'Supplier berhasil dihapus.');
    }
}