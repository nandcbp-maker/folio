<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_institusi' => 'required|string',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string',
            'kode_pos' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|email',
            'format_nomor_surat' => 'nullable|string',
            'digit_nomor' => 'nullable|integer',
            'reset_nomor' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'tanda_tangan' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $setting = Setting::first();
        if (!$setting) {
            $setting = new Setting();
        }

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('tanda_tangan')) {
            if ($setting->tanda_tangan) {
                Storage::disk('public')->delete($setting->tanda_tangan);
            }
            $validated['tanda_tangan'] = $request->file('tanda_tangan')->store('settings', 'public');
        }

        $setting->fill($validated)->save();

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
