<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Jenis::class);

        $keyword = $request->input('search');

        $jenis = Jenis::when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->orderBy('nama', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('jenis.index', compact('jenis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Jenis::class);

        return view('jenis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Jenis::class);

        // Validasi agar nama jenis bersifat unik (tidak boleh duplikat)
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis,nama',
        ], [
            'nama.unique' => 'Kategori/Jenis ini sudah ada, silakan gunakan nama lain.',
            'nama.required' => 'Nama jenis wajib diisi.',
        ]);

        Jenis::create([
            'nama' => trim($request->nama),
        ]);

        return redirect()
            ->route('jenis.index')
            ->with('success', 'Jenis berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jenis $jeni)
    {
        $this->authorize('update', $jeni);

        return view('jenis.edit', compact('jeni'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jenis $jeni)
    {
        $this->authorize('update', $jeni);

        // Validasi unik, mengabaikan ID jenis yang sedang diedit
        $request->validate([
            'nama' => 'required|string|max:255|unique:jenis,nama,' . $jeni->id,
        ], [
            'nama.unique' => 'Kategori/Jenis ini sudah ada, silakan gunakan nama lain.',
            'nama.required' => 'Nama jenis wajib diisi.',
        ]);

        $jeni->update([
            'nama' => trim($request->nama),
        ]);

        return redirect()
            ->route('jenis.index')
            ->with('success', 'Jenis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jenis $jeni)
    {
        $this->authorize('delete', $jeni);

        $jeni->delete();

        return redirect()
            ->route('jenis.index')
            ->with('success', 'Jenis berhasil dihapus.');
    }
}