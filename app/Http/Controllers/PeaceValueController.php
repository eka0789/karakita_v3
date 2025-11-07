<?php

namespace App\Http\Controllers;

use App\Models\PeaceValue;
use Illuminate\Http\Request;

class PeaceValueController extends Controller
{
    /**
     * Daftar nilai karakter
     */
    public function index()
    {
        $peaceValues = PeaceValue::orderBy('id')->get();
        return view('peacevalues.index', compact('peaceValues'));
    }

    /**
     * Tampilkan form tambah nilai karakter
     */
    public function create()
    {
        return view('peacevalues.create');
    }

    /**
     * Simpan nilai karakter baru
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);

        PeaceValue::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('peacevalues.index')->with('success', 'Nilai karakter berhasil ditambahkan!');
    }

    /**
     * Form edit nilai karakter
     */
    public function edit(PeaceValue $peacevalue)
    {
        return view('peacevalues.edit', compact('peacevalue'));
    }

    /**
     * Update data nilai karakter
     */
    public function update(Request $request, PeaceValue $peacevalue)
    {
        $request->validate(['name' => 'required|string|max:100']);

        $peacevalue->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('peacevalues.index')->with('success', 'Nilai karakter berhasil diperbarui!');
    }

    /**
     * Hapus nilai karakter
     */
    public function destroy(PeaceValue $peacevalue)
    {
        $peacevalue->delete();
        return redirect()->route('peacevalues.index')->with('success', 'Nilai karakter berhasil dihapus!');
    }
}
