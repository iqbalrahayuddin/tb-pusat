<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengeluarans = Pengeluaran::where('id_saas', Auth::user()->id_saas)
                                    ->latest()
                                    ->get();
                                    
        return view('input-pengeluaran', compact('pengeluarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:0',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('bukti')) {
            $path = $request->file('bukti')->store('public/bukti_pengeluaran');
        }

        try {
            // 3. Mulai Transaksi Database
            $newPengeluaran = DB::transaction(function () use ($request, $path) {
                
                $prefix = 'TB-K-' . date('ymd');
                $id_saas = Auth::user()->id_saas; // id_saas tetap dipakai untuk disimpan

                // 4. Kueri yang DIPERBAIKI:
                // Kita hapus ->where('id_saas', $id_saas)
                // agar generatornya mencari nomor terakhir secara GLOBAL,
                // sesuai dengan constraint UNIQUE di database.
                $lastData = Pengeluaran::where('nomor_nota', 'LIKE', $prefix . '-%') // <-- BARIS INI DIUBAH
                                        ->latest('id')
                                        ->lockForUpdate()
                                        ->first();

                $nextNumber = 1;
                if ($lastData) {
                    $lastSequence = (int) substr($lastData->nomor_nota, -4);
                    $nextNumber = $lastSequence + 1;
                }

                $sequence = str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                $nomorNota = $prefix . '-' . $sequence;

                // 5. Buat Data
                return Pengeluaran::create([
                    'id_saas' => $id_saas, // Simpan id_saas milik user
                    'nomor_nota' => $nomorNota, 
                    'tanggal' => $request->tanggal,
                    'keterangan' => $request->keterangan,
                    'kredit' => $request->kredit,
                    'bukti' => $path,
                ]);
            });

            // 6. Redirect jika sukses
            return Redirect::route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil disimpan.');

        } catch (\Exception $e) {
            // 7. Jika GAGAL
            if ($path) {
                Storage::delete($path);
            }
            
            return Redirect::back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $request->validate([
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:0',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $pengeluaran = Pengeluaran::findOrFail($id);

        if ($pengeluaran->id_saas != Auth::user()->id_saas) {
            abort(403, 'Akses ditolak.');
        }

        $dataToUpdate = [
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'kredit' => $request->kredit,
        ];

        if ($request->hasFile('bukti')) {
            if ($pengeluaran->bukti) {
                Storage::delete($pengeluaran->bukti);
            }
            $path = $request->file('bukti')->store('public/bukti_pengeluaran');
            $dataToUpdate['bukti'] = $path;
        }

        $pengeluaran->update($dataToUpdate);

        return Redirect::route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        if ($pengeluaran->id_saas != Auth::user()->id_saas) {
            abort(403, 'Akses ditolak.');
        }

        if ($pengeluaran->bukti) {
            Storage::delete($pengeluaran->bukti);
        }

        $pengeluaran->delete();

        return Redirect::route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus.');
    }

    /**
     * Tampilkan file bukti.
     */
    public function showBukti(string $id)
    {
        $pengeluaran = Pengeluaran::findOrFail($id);

        if ($pengeluaran->id_saas != Auth::user()->id_saas) {
            abort(403, 'Akses ditolak.');
        }

        if (!$pengeluaran->bukti || !Storage::exists($pengeluaran->bukti)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::response($pengeluaran->bukti);
    }
}