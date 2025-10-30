<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani oleh middleware 'auth'
        return true; 
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id_saas = auth()->user()->id_saas;

        // Dapatkan ID produk saat ini (jika ada, untuk Rute 'update')
        // $this->route('produk') akan berisi model Produk saat update
        $produkId = $this->route('produk') ? $this->route('produk')->id : null;

        return [
            'nama_produk' => 'required|string|max:255',
            
            // 'stok', 'harga_beli', 'harga_jual' dihapus
            
            // Aturan validasi untuk id_produk
            'id_produk' => [
                'required',
                'string',
                'max:100', // Sesuaikan panjang maksimal jika perlu
                // Aturan unik:
                // 1. Cek di tabel 'produks'
                // 2. Hanya cek yang 'id_saas' nya sama
                // 3. Abaikan 'id' produk itu sendiri (penting untuk update)
                Rule::unique('produks')->where('id_saas', $id_saas)->ignore($produkId),
            ],
            
            // Pastikan kategori_id yang dikirim ada di tabel kategoris DAN 
            // dimiliki oleh id_saas yang sama
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists('kategoris', 'id')->where('id_saas', $id_saas),
            ],
        ];
    }
}