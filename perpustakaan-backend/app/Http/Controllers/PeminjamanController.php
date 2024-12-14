<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Peminjaman\PeminjamanService;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    protected $peminjamanService;

    public function __construct(PeminjamanService $peminjamanService) {
        $this->peminjamanService = $peminjamanService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json($this->peminjamanService->getAll());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json($this->peminjamanService->create($request));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return response()->json($this->peminjamanService->update($request, $peminjaman));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return response()->json($this->peminjamanService->delete($peminjaman));
    }
}
