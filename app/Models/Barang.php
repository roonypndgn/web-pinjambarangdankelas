<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'kategori_id',
        'merk',
        'deskripsi',
        'jumlah',
        'cover'
    ];
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class); 
    }
}
