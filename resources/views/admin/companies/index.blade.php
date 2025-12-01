@extends('admin.layouts.app')

@section('title', 'Manajemen Perusahaan')

@section('content')

    <!-- Companies Section -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Kelola Perusahaan</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold">PT</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">PT Tech Indonesia</h4>
                                        <p class="text-sm text-gray-600">Teknologi</p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p>📍 Jakarta</p>
                                    <p>👥 50-100 karyawan</p>
                                    <p>📋 5 lowongan aktif</p>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    <button class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded">Lihat Detail</button>
                                    <button class="px-3 py-1 text-xs bg-gray-100 text-gray-800 rounded">Hapus</button>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold">CV</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">CV Maju Bersama</h4>
                                        <p class="text-sm text-gray-600">Marketing</p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p>📍 Bandung</p>
                                    <p>👥 20-50 karyawan</p>
                                    <p>📋 3 lowongan aktif</p>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    <button class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded">Lihat Detail</button>
                                    <button class="px-3 py-1 text-xs bg-gray-100 text-gray-800 rounded">Hapus</button>
                                </div>
                            </div>

                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold">DS</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">PT Digital Solutions</h4>
                                        <p class="text-sm text-gray-600">IT Services</p>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm text-gray-600">
                                    <p>📍 Surabaya</p>
                                    <p>👥 100+ karyawan</p>
                                    <p>📋 7 lowongan aktif</p>
                                </div>
                                <div class="mt-4 flex space-x-2">
                                    <button class="px-3 py-1 text-xs bg-blue-100 text-blue-800 rounded">Lihat Detail</button>
                                    <button class="px-3 py-1 text-xs bg-gray-100 text-gray-800 rounded">Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection