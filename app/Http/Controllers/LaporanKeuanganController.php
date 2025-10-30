<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;

class LaporanKeuanganController extends Controller
{
    /**
     * Helper private function untuk mengambil data
     * Ini untuk menghindari duplikasi kode antara index, download, dan cetak
     */
    private function getLaporanData(Request $request)
    {
        $id_saas = Auth::user()->id_saas;

        $pemasukanQuery = Pemasukan::where('id_saas', $id_saas)
            ->selectRaw("tanggal, nomor_nota, keterangan, debit, NULL as kredit");
        
        $pengeluaranQuery = Pengeluaran::where('id_saas', $id_saas)
            ->selectRaw("tanggal, nomor_nota, keterangan, NULL as debit, kredit");

        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');

        if ($dari_tanggal && $sampai_tanggal) {
            $pemasukanQuery->whereBetween('tanggal', [$dari_tanggal, $sampai_tanggal]);
            $pengeluaranQuery->whereBetween('tanggal', [$dari_tanggal, $sampai_tanggal]);
        }

        $laporan = $pemasukanQuery
            ->union($pengeluaranQuery)
            ->orderBy('tanggal', 'asc')
            ->get();

        $totalDebit = $laporan->sum('debit');
        $totalKredit = $laporan->sum('kredit');
        $saldoAkhir = $totalDebit - $totalKredit;

        return [
            'laporan' => $laporan,
            'totalDebit' => $totalDebit,
            'totalKredit' => $totalKredit,
            'saldoAkhir' => $saldoAkhir,
            'dari_tanggal' => $dari_tanggal,
            'sampai_tanggal' => $sampai_tanggal,
        ];
    }

    /**
     * Menampilkan halaman laporan keuangan.
     */
    public function index(Request $request)
    {
        $data = $this->getLaporanData($request);
        $data['is_pdf'] = false; // Tambahkan flag untuk view
        
        return view('laporan-keuangan', $data);
    }

    /**
     * Membuat dan mengunduh laporan keuangan sebagai PDF.
     */
    public function downloadPDF(Request $request)
    {
        $data = $this->getLaporanData($request);
        
        // Tambahkan data tambahan untuk PDF
        $data['is_pdf'] = true;
        $data['tanggal_cetak'] = Carbon::now()->format('d-m-Y H:i');

        $fileName = 'Laporan_Keuangan_' . date('Y-m-d') . '.pdf';

        $pdf = PDF::loadView('laporan-keuangan', $data); 
        return $pdf->download($fileName); // Mengunduh file
    }

    /**
     * == METODE BARU UNTUK CETAK PDF ==
     *
     * Membuat dan menampilkan laporan keuangan sebagai PDF di browser.
     */
    public function cetakPDF(Request $request)
    {
        $data = $this->getLaporanData($request);

        // Tambahkan data tambahan untuk PDF
        $data['is_pdf'] = true;
        $data['tanggal_cetak'] = Carbon::now()->format('d-m-Y H:i');

        $fileName = 'Laporan_Keuangan_' . date('Y-m-d') . '.pdf';

        $pdf = PDF::loadView('laporan-keuangan', $data);
        return $pdf->stream($fileName); // Menampilkan file di browser
    }
}