<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'ruang_id',
        'barang_id',
        'JumlahBarang',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'ruang_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'barang_id');
    }
}
