<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'NamaRuang',
        'Kapasitas',
        'Gambar',
    ];

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'ruang_id');
    }
}
