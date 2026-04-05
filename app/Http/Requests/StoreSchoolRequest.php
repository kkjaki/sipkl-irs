<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Izinkan jika user sudah login dan memiliki role 'owner'
        if ($this->user() && $this->user()->role === 'owner') {
            return true;
        }

        return false;
    }

    public function rules(): array
    {
        return [
            // Tambahin 'unique:schools,name' biar gak ada nama sekolah kembar
            'name' => ['required', 'string', 'max:255', 'unique:schools,name'],
            'address' => ['required', 'string', 'max:1000'],
            'phone' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Custom pesan error biar user nggak bingung
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Nama sekolah ini sudah terdaftar di sistem!',
            'name.required' => 'Nama sekolah wajib diisi.',
            'address.required' => 'Alamat sekolah tidak boleh kosong.',
        ];
    }
}
