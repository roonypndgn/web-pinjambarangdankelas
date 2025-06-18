<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategoris';
    protected $primaryKey = 'id';
    protected $fillable = ['id','nama','deskripsi'];

}
