<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PemasukanController extends Controller
{
    /**
     * Menampilkan semua data pemasukan berdasarkan id_saas user.
     */
    public function index()
    {
        $pemasukans = Pemasukan::where('id_saas', Auth::user()->id_saas)
            ->latest() 
            ->get();
            
        return view('input-pemasukan', compact('pemasukans'));
    }

    /**
     * Menyimpan data pemasukan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:0',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $id_saas = Auth::user()->id_saas;
        $buktiPath = null;

        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('public/bukti_pemasukan', 'local');
        }

        // === PERUBAHAN DI SINI ===
        // 1. Tambahkan $id_saas ke prefix
        $prefix = 'TB-' . $id_saas . '-' . now()->format('ymd') . '-';
        
        // 2. Query pencarian terakhir HARUS mencocokkan prefix baru
        $lastPemasukan = Pemasukan::where('nomor_nota', 'LIKE', $prefix . '%')
            ->where('id_saas', $id_saas) // Jaga ini untuk keamanan
            ->latest('id')
            ->first();

        $nextNumber = 1;
        if ($lastPemasukan) {
            $lastNumber = (int)substr($lastPemasukan->nomor_nota, -3);
            $nextNumber = $lastNumber + 1;
        }

        $nomorNota = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        // Hasil: TB-1-251030-001, TB-2-251030-001, dst.
        // === AKHIR PERUBAHAN ===

        Pemasukan::create([
            'id_saas' => $id_saas,
            'nomor_nota' => $nomorNota,
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'],
            'debit' => $validated['debit'],
            'bukti' => $buktiPath,
        ]);

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil ditambahkan.');
    }

    /**
     * Menampilkan file bukti yang aman.
     */
    public function show(Pemasukan $pemasukan)
    {
        // 1. Otorisasi
        if ($pemasukan->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak.');
        }

        $pathDiDatabase = $pemasukan->bukti;

        // 2. Cek database
        if (!$pathDiDatabase) {
            abort(404, 'Data bukti tidak ditemukan di database.');
        }

        // 3. Cek filesystem
        if (!Storage::disk('local')->exists($pathDiDatabase)) {
            abort(404, 'File bukti fisik tidak ditemukan di server. (File: ' . $pathDiDatabase . ')');
        }

        // 4. Ambil path absolut
        $pathAbsolut = Storage::disk('local')->path($pathDiDatabase);
        
        // 5. Kirim file ke browser
        return response()->file($pathAbsolut);
    }


    /**
     * Memperbarui data pemasukan.
     */
    public function update(Request $request, Pemasukan $pemasukan)
    {
        if ($pemasukan->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak.');
        }

        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:0',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPath = $pemasukan->bukti; 

        if ($request->hasFile('bukti')) {
            if ($pemasukan->bukti && Storage::disk('local')->exists($pemasukan->bukti)) {
                Storage::disk('local')->delete($pemasukan->bukti);
            }
            $buktiPath = $request->file('bukti')->store('public/bukti_pemasukan', 'local');
        }

        $pemasukan->update([
            'tanggal' => $validated['tanggal'],
            'keterangan' => $validated['keterangan'],
            'debit' => $validated['debit'],
            'bukti' => $buktiPath,
        ]);

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diperbarui.');
    }

    /**
     * Menghapus data pemasukan.
     */
    public function destroy(Pemasukan $pemasukan)
    {
        if ($pemasukan->id_saas !== Auth::user()->id_saas) {
            abort(403, 'Akses ditolak.'); 
        }

        if ($pemasukan->bukti && Storage::disk('local')->exists($pemasukan->bukti)) {
            Storage::disk('local')->delete($pemasukan->bukti);
        }

        $pemasukan->delete();

        return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil dihapus.');
    }
}