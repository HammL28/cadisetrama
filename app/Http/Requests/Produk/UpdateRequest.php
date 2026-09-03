<?php

namespace App\Http\Requests\Produk;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Membersihkan pemisah ribuan/titik sebelum validasi berjalan.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'purchase_price' => $this->purchase_price ? preg_replace('/[^0-9]/', '', $this->purchase_price) : null,
            'selling_price'  => $this->selling_price ? preg_replace('/[^0-9]/', '', $this->selling_price) : null,
            'stock'          => $this->stock ? preg_replace('/[^0-9]/', '', $this->stock) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis'          => 'required|string|max:100',
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock'          => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'foto.image'              => 'File yang diupload harus gambar.',
            'foto.mimes'              => 'Ekstensi gambar harus JPG, JPEG, PNG.',
            'foto.max'                => 'Maksimal ukuran gambar 2MB.',
            'jenis.required'          => 'Jenis / Kategori produk wajib dipilih.',
            'name.required'           => 'Nama wajib diisi.',
            'purchase_price.required' => 'Harga beli wajib diisi.',
            'purchase_price.numeric'  => 'Harga beli harus berupa angka.',
            'selling_price.required'  => 'Harga jual wajib diisi.',
            'selling_price.numeric'   => 'Harga jual harus berupa angka.',
            'stock.required'          => 'Stok wajib diisi.',
            'stock.integer'           => 'Stok harus berupa angka.',
        ];
    }
}