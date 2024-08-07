<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';
    
    protected $fillable = [
        'peminjam_id',
        'NamaPeminjam',
        'TimPelayanan',
        'Jumlah',
        'Deskripsi',
        'ruang_id',
        'TanggalPinjam',
        'JamMulai',
        'JamSelesai',
        'Persetujuan',
        'Pengaduan',
        'Aduan1',
        'Aduan2',
        'Aduan3',
    ];
    public function user()
    {
        return $this->belongsTo(User::class,'peminjam_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class,'ruang_id'  );
    }

}

