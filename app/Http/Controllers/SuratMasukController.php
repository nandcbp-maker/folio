<?php

namespace App\Http\Controllers;

use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuratMasukController extends Controller
{
    public function index()
    {
        $suratMasuk = SuratMasuk::latest()->paginate(10);
        
        $stats = [
            'total' => SuratMasuk::count(),
            'pending' => SuratMasuk::where('status', 'PENDING')->count(),
            'processed' => SuratMasuk::where('status', 'PROCESSED')->count(),
            'archived_this_month' => SuratMasuk::where('status', 'ARCHIVED')
                                    ->whereMonth('created_at', now()->month)
                                    ->count(),
        ];

        return view('surat-masuk.index', compact('suratMasuk', 'stats'));
    }

    public function create()
    {
        return view('surat-masuk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_berkas' => 'required|string',
            'perihal' => 'required|string',
            'asal_instansi' => 'required|string',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'kategori' => 'required|string',
            'file_surat' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file_surat')) {
            $path = $request->file('file_surat')->store('surat-masuk');
            $validated['file_path'] = $path;
        }

        SuratMasuk::create($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil ditambahkan.');
    }

    public function show(SuratMasuk $suratMasuk)
    {
        $suratMasuk->load('disposisi.pengirim', 'disposisi.penerima');
        return view('surat-masuk.show', compact('suratMasuk'));
    }

    public function edit(SuratMasuk $suratMasuk)
    {
        return view('surat-masuk.edit', compact('suratMasuk'));
    }

    public function update(Request $request, SuratMasuk $suratMasuk)
    {
        $validated = $request->validate([
            'no_berkas' => 'required|string',
            'perihal' => 'required|string',
            'asal_instansi' => 'required|string',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'required|date',
            'kategori' => 'required|string',
            'status' => 'required|string',
        ]);

        if ($request->hasFile('file_surat')) {
            if ($suratMasuk->file_path) {
                Storage::delete($suratMasuk->file_path);
            }
            $path = $request->file('file_surat')->store('surat-masuk');
            $validated['file_path'] = $path;
        }

        $suratMasuk->update($validated);

        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil diperbarui.');
    }

    public function destroy(SuratMasuk $suratMasuk)
    {
        if ($suratMasuk->file_path) {
            Storage::delete($suratMasuk->file_path);
        }
        $suratMasuk->delete();
        return redirect()->route('surat-masuk.index')->with('success', 'Surat masuk berhasil dihapus.');
    }
}
