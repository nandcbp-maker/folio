<?php

namespace App\Http\Controllers;

use App\Models\Disposisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposisiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'surat_masuk_id' => 'required|exists:surat_masuk,id',
            'penerima_id' => 'required|exists:users,id',
            'instruksi' => 'required|string',
            'status' => 'required|string',
        ]);

        $validated['pengirim_id'] = Auth::id();

        Disposisi::create($validated);

        return back()->with('success', 'Disposisi berhasil dikirim.');
    }
}
