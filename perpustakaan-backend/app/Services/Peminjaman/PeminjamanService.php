<?php

namespace App\Services\Peminjaman;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PeminjamanService implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show'])
        ];
    }

    public function index()
    {
        return Peminjaman::all();
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:bukus,id',
            'tgl_pinjam' => 'required|date',
        ]);

        $peminjaman = $request->user()->peminjaman()->create($fields);

        return $peminjaman;
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        Gate::authorize('modify', $peminjaman);

        $fields = $request->validate([
            'id_user' => 'sometimes|exists:users,id',
            'id_buku' => 'sometimes|exists:bukus,id',
            'tgl_pinjam' => 'sometimes|date',
        ]);

        $peminjaman->update($fields);

        return $peminjaman;
    }

    public function delete(Peminjaman $peminjaman)
    {
        Gate::authorize('modify', $peminjaman);

        $peminjaman->delete();

        return ['message' => 'Peminjaman berhasil dihapus'];
    }

    public function show(Peminjaman $peminjaman)
    {
        return $peminjaman; 
    }
}
