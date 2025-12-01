@extends('admin.layouts.app')

@section('title', 'Pengaturan Sistem')

@section('content')

   

                    <!-- Admin Management -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Manajemen Admin</h3>
                            <p class="text-sm text-gray-600 mt-1">Kelola akses dan peran admin platform</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                                            <span class="text-white font-medium">A</span>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900">Admin Utama</h4>
                                            <p class="text-sm text-gray-600">admin@carepro.com</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Super Admin</span>
                                </div>
                                
                            <div class="mt-6">
                                <button class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors">
                                    Tambah Admin Baru
                                </button>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection