<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            // USERS
            'name' => 'required|string|max:100',

            'email' => 'required|email|unique:users,email',

            // MAHASISWA
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',

            'program_studi_id' => 'required|exists:program_studis,id',

            'tanggal_lahir' => 'required|date',

            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',

            'alamat' => 'required|string',

            'no_hp' => 'required|string|max:20',

            'angkatan_id' => 'required|exists:angkatans,id',

            'hobby_id' => 'required|exists:hobbies,id',

            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];
    }
}
