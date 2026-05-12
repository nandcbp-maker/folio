<?php

namespace App\Http\Controllers;

use App\Models\SuratKeluar;
use App\Models\Setting;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $suratKeluar = SuratKeluar::latest()->paginate(10);
        return view('surat-keluar.index', compact('suratKeluar'));
    }

    public function create()
    {
        $setting = Setting::first();
        return view('surat-keluar.create', compact('setting'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string',
            'perihal' => 'required|string',
            'tujuan' => 'required|string',
            'tanggal_surat' => 'required|date',
            'isi_surat' => 'required|string',
            'template_type' => 'required|string',
        ]);

        SuratKeluar::create($validated);

        return redirect()->route('surat-keluar.index')->with('success', 'Surat keluar berhasil dibuat.');
    }
}
