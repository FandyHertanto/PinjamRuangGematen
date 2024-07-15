<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'NamaBarang',
        'Deskripsi',
    ];

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'barang_id');
    }
}
