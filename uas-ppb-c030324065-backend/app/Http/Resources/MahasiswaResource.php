<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MahasiswaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,

            'nama' => $this->user->name,

            'email' => $this->user->email,

            'nim' => $this->nim,

            'tanggal_lahir' => $this->tanggal_lahir,

            'jenis_kelamin' => $this->jenis_kelamin,

            'alamat' => $this->alamat,

            'no_hp' => $this->no_hp,

            'foto' => $this->foto
                ? asset('storage/' . $this->foto)
                : null,

            'program_studi' => $this->programStudi,

            'angkatan' => $this->angkatan,

            'hobby' => $this->hobby,

            'created_at' => $this->created_at,

            'updated_at' => $this->updated_at,
        ];
    }
}
