<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Menampilkan formulir pengaturan.
     * Route: GET /backoffice/settings (admin.settings.index)
     */
    public function index()
    {
        // Logika untuk mengambil data pengaturan saat ini dari database/cache
        $settings = [
            'site_name' => 'CarePro',
            'is_maintenance' => false,
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memperbarui pengaturan sistem.
     * Route: PUT /backoffice/settings (admin.settings.update)
     */
    public function update(Request $request)
    {
        // 1. Lakukan validasi data input
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'is_maintenance' => 'boolean',
        ]);
        
        // 2. Simpan perubahan ke database (misalnya, menggunakan tabel 'settings')
        // Setting::updateOrCreate(['key' => 'site_name'], ['value' => $validatedData['site_name']]);
        // Setting::updateOrCreate(['key' => 'is_maintenance'], ['value' => $request->has('is_maintenance')]);

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}