<?php

namespace App\Models;

use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'kategori_id',
        'merk',
        'deskripsi',
        'status',
        'jumlah',
        'cover' 
    ];
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class); 
    }
}
