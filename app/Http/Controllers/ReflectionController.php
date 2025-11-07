<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reflection;
use Carbon\Carbon;

class ReflectionController extends Controller
{
    /**
     * Tampilkan daftar refleksi siswa (hanya milik dirinya)
     */
    public function index()
    {
        $reflections = Reflection::where('student_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('refleksi.index', compact('reflections'));
    }

    /**
     * Form menulis refleksi baru
     */
    public function create()
    {
        return view('refleksi.create');
    }

    /**
     * Simpan refleksi ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|min:10',
        ]);

        Reflection::create([
            'student_id' => Auth::id(),
            'content' => $request->content,
            'created_at' => Carbon::now(),
        ]);

        return redirect()->route('student.refleksi.index')
            ->with('success', 'Refleksi berhasil dikirim!');
    }

    /**
     * Lihat detail refleksi
     */
    public function show(Reflection $refleksi)
    {
        abort_if($refleksi->student_id !== Auth::id(), 403);
        return view('refleksi.show', compact('refleksi'));
    }
}
