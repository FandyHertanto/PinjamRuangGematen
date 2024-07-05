<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruang_id',
        'peminjam_id',
        'TanggalPinjam',
        'JamMulai',
        'JamSelesai',
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
