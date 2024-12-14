<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku;
use App\Models\User;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * Table name for this model.
     */
    protected $table = 'peminjamans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user',
        'id_buku',
        'tgl_pinjam',
    ];

    /**
     * Relasi dengan user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    /**
     * Relasi dengan buku.
     */
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku', 'id_buku');
    }
}
