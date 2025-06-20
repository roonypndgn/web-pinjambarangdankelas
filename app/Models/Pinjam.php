<?php

namespace App\Models;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjam extends Model
{
    use HasFactory;
    protected $table = 'pinjams';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'barang_id',
        'user_id',
        'tgl_pinjam',
        'tgl_kembali',
        'time_pinjam',
        'time_kembali',
        'status'
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
