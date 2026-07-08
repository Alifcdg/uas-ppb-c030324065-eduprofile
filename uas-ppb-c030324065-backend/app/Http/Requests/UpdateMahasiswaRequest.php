<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mahasiswa = $this->route('mahasiswa');

        return [
            'nama' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($mahasiswa->user_id),
            ],

            'nim' => [
                'required',
                Rule::unique('mahasiswas', 'nim')->ignore($mahasiswa->id),
            ],

            'program_studi_id' => 'required|exists:program_studis,id',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'angkatan_id' => 'required|exists:angkatans,id',
            'hobby_id' => 'required|exists:hobbies,id',
        ];
    }
}
