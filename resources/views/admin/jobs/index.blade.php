@extends('admin.layouts.app')

@section('title', 'Kelola Lowongan')

@section('content')

   <!-- Jobs Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900">Lowongan</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Posisi</th>
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Perusahaan</th>
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Lokasi</th>
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Dibuat Oleh</th>
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Status</th>
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Lamaran</th>
                                        <th class="text-left py-3 px-4 font-medium text-gray-900">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-100">
                                        <td class="py-4 px-4">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Frontend Developer</h4>
                                                <p class="text-sm text-gray-600">Full-time • Rp 8-12 juta</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-gray-900">PT Tech Indonesia</td>
                                        <td class="py-4 px-4 text-gray-600">Jakarta</td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full">Admin</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                                        </td>
                                        <td class="py-4 px-4 text-gray-900">23</td>
                                        <td class="py-4 px-4">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-800 text-sm">Lihat</button>
                                                <button class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100">
                                        <td class="py-4 px-4">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Marketing Manager</h4>
                                                <p class="text-sm text-gray-600">Full-time • Rp 10-15 juta</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-gray-900">CV Maju Bersama</td>
                                        <td class="py-4 px-4 text-gray-600">Bandung</td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">Perusahaan</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Aktif</span>
                                        </td>
                                        <td class="py-4 px-4 text-gray-900">15</td>
                                        <td class="py-4 px-4">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-800 text-sm">Lihat</button>
                                                <button class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-100">
                                        <td class="py-4 px-4">
                                            <div>
                                                <h4 class="font-medium text-gray-900">Data Analyst</h4>
                                                <p class="text-sm text-gray-600">Full-time • Rp 7-10 juta</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-gray-900">PT Digital Solutions</td>
                                        <td class="py-4 px-4 text-gray-600">Surabaya</td>
                                        <td class="py-4 px-4">
                                            <span class="px-2 py-1 text-xs font-medium text-purple-800 bg-purple-100 rounded-full">Perusahaan</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span class="px-3 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full">Review</span>
                                        </td>
                                        <td class="py-4 px-4 text-gray-900">8</td>
                                        <td class="py-4 px-4">
                                            <div class="flex space-x-2">
                                                <button class="text-blue-600 hover:text-blue-800 text-sm" onclick="approveJob(this)">Setujui</button>
                                                <button class="text-red-600 hover:text-red-800 text-sm">Tolak</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection