<?php

namespace App\Models;

use App\Models\Pinjam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalians';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'pinjam_id',
        'tgl_kembali',
        'time_kembali'
    ];
    public function pinjam(): BelongsTo
    {
        return $this->belongsTo(Pinjam::class);
    }
}
