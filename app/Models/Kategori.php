<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategoris';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama','deskripsi'];

     // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
