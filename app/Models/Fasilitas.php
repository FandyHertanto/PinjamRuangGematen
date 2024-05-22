<?php

// app/Models/Fasilitas.php
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
        'barang_id', // Use barang_id
        'JumlahBarang',
    ];

    public function Room()
    {
        // return $this->belongsTo(Room::class, 'ruang_id');
        // return $this->belongsTo(Room::class, 'id', 'ruang_id');
        return $this->hasOne(Room::class, 'id', 'ruang_id');
    }

    public function Item()
    {
        return $this->belongsTo(Item::class, 'barang_id');
        // return $this->belongsTo(Item::class, 'id', 'barang_id');
        // return $this->hasMany(Item::class, 'id', 'barang_id');
    }
}
