<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // <<< TAMBAHKAN INI

class NewsController extends Controller
{
    /**
     * Menampilkan daftar semua berita. (READ)
     */
    public function index()
    {
        $news = Berita::orderBy('created_at', 'desc')->get();
        return view('admin.news.index', compact('news')); 
    }

    /**
     * Menampilkan form untuk membuat berita baru. (CREATE - Form)
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Menyimpan berita baru ke database. (CREATE - Store)
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambarPath = null;
        // 2. Upload Gambar (jika ada)
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('news_images', 'public');
        }

        // 3. Simpan Data ke Database
        Berita::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar' => $gambarPath,
            // PERBAIKAN DI SINI (Baris 56 sebelumnya)
            'penulis' => Auth::check() ? Auth::user()->nama : 'Admin', 
            'slug' => Str::slug($request->judul),
        ]);

        return redirect()->route('admin.news.index')
                         ->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit berita. (UPDATE - Form)
     */
    public function edit(Berita $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Mengupdate data berita di database. (UPDATE - Store)
     */
    public function update(Request $request, Berita $news)
    {
        // 1. Validasi Data
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);

        $gambarPath = $news->gambar;
        
        // 2. Upload Gambar Baru (jika ada)
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($news->gambar) {
                Storage::disk('public')->delete($news->gambar);
            }
            $gambarPath = $request->file('gambar')->store('news_images', 'public');
        }

        // 3. Update Data
        $news->update([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'gambar' => $gambarPath,
            // PERBAIKAN DI SINI (Baris 100 sebelumnya)
            'penulis' => Auth::check() ? Auth::user()->nama : 'Admin', 
            'slug' => Str::slug($request->judul),
        ]);

        return redirect()->route('admin.news.index')
                         ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Menghapus berita dari database. (DELETE)
     */
    public function destroy(Berita $news)
    {
        // Hapus gambar terkait
        if ($news->gambar) {
            Storage::disk('public')->delete($news->gambar);
        }
        
        $news->delete();

        return redirect()->route('admin.news.index')
                         ->with('success', 'Berita berhasil dihapus.');
    }
}