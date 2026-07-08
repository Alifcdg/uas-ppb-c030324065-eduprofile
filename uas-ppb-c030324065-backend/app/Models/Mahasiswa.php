<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nim',
        'program_studi_id',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'angkatan_id',
        'hobby_id',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

    public function angkatan()
    {
        return $this->belongsTo(Angkatan::class);
    }

    public function hobby()
    {
        return $this->belongsTo(Hobby::class);
    }
}
