<?php

namespace App\Http\Requests\Produk;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis'          => 'required|string|max:100',
            'name'           => 'required|string|max:255',
            'purchase_price' => 'required|integer|min:0',
            'selling_price'  => 'required|integer|min:0',
            'stock'          => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'foto.image'              => 'File yang diupload harus gambar.',
            'foto.mimes'              => 'Extensi gambar harus JPG, JPEG, PNG.',
            'foto.max'                => 'Maksimal ukuran gambar 2MB.',
            'jenis.required'          => 'Jenis / Kategori produk wajib dipilih.',
            'name.required'           => 'Nama wajib diisi.',
            'purchase_price.required' => 'harga beli wajib diisi.',
            'purchase_price.integer'  => 'harga beli harus diisi bilangan bulat.',
            'selling_price.required'  => 'harga jual wajib diisi.',
            'selling_price.integer'   => 'harga jual harus diisi bilangan bulat.',
            'stock.required'          => 'Stock wajib diisi.',
            'stock.integer'           => 'Stock harus diisi angka.',
        ];
    }
}