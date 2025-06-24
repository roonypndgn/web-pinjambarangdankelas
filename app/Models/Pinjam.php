<?php

namespace App\Models;
use App\Models\User;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pinjam extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'barang_id',
        'user_id',
        'tgl_pinjam',
        'time_pinjam',
        'status',
        'admin_notes'
];
        public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
