@extends('layouts.master')

@section('title', 'Kelola Lowongan')
@section('page-title', 'Kelola Lowongan')

{{-- 
    ====================================================================
    CSS KHUSUS UNTUK KEDUA MODAL (SUKSES & DELETE)
    ====================================================================
--}}
@push('styles')
<style>
    /* Modal Overlay (Berlaku untuk Modal Sukses dan Modal Hapus) */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 11000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    /* Modal Box Umum */
    .success-modal-box {
        background: white;
        width: 350px;
        padding: 30px 20px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .modal-overlay.show .success-modal-box {
        transform: scale(1); /* Animasi membesar saat muncul */
    }

    .modal-icon {
        font-size: 60px;
        margin-bottom: 15px;
    }

    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .modal-message {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 25px;
        line-height: 1.5;
    }
    
    /* --- STYLE KHUSUS MODAL SUKSES --- */
    .success-modal-box .modal-icon {
        color: #10b981;
    }
    
    .modal-close-btn {
        background: #2563eb;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }
    .modal-close-btn:hover {
        background: #1e40af;
    }

    /* --- STYLE KHUSUS MODAL HAPUS --- */
    .delete-modal-box {
        width: 380px !important; 
    }
    .delete-icon {
        color: #ef4444 !important; /* Warna Ikon Merah */
    }
    .delete-title {
        color: #b91c1c !important;
    }
    .delete-message {
        color: #4b5563 !important;
        text-align: center;
    }
    
    /* Flexbox untuk tombol konfirmasi hapus */
    .d-flex {
        display: flex;
    }
    .justify-content-center {
        justify-content: center;
    }
    .gap-3 {
        gap: 1rem; /* Jarak antara tombol */
    }
    
    .cancel-btn {
        background: #6b7280 !important; /* Tombol Abu-abu untuk Batal */
    }
    .cancel-btn:hover {
        background: #4b5563 !important;
    }
    .delete-confirm-btn {
        background: #dc2626 !important; /* Tombol Merah untuk Hapus */
    }
    .delete-confirm-btn:hover {
        background: #991b1b !important;
    }
    
    /* Style untuk form pencarian */
    .card-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .input-group {
        display: flex;
        width: 350px; /* Lebar form pencarian */
    }
</style>
@endpush

@section('content')

    {{-- Kode untuk menampilkan Modal Sukses sudah ada di sini --}}
    
    <div class="card bg-white p-6 rounded-xl shadow-lg mt-4">
        <div class="card-header pb-4 border-b border-gray-200 mb-4 flex justify-between items-center">
            <h3 class="card-title text-xl font-semibold text-gray-800">Daftar Lowongan Pekerjaan</h3>
            <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-primary bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg">
                <i class="fas fa-plus-circle me-1"></i> Tambah Lowongan
            </a>
        </div>
        
        <div class="card-body">
            @if ($lowongans->count() > 0)
                <div class="table-responsive overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batas Lamaran</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- 🔥 Bagian PENTING: Perulangan Data Lowongan 🔥 --}}
                            @foreach ($lowongans as $lowongan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $lowongan->posisi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lowongan->lokasi }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $lowongan->tipe_pekerjaan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Menampilkan status dengan badge --}}
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($lowongan->status == 'Aktif') bg-green-100 text-green-800
                                            @elseif($lowongan->status == 'Non-Aktif') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ $lowongan->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($lowongan->batas_lamaran)->format('d F Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('perusahaan.lowongan.edit', $lowongan->id) }}" class="text-indigo-600 hover:text-indigo-900 me-2"><i class="fas fa-edit"></i> Edit</a>
                                        
                                        {{-- Tombol Hapus: Menggunakan modal yang sudah ada --}}
                                        <a href="#" onclick="openDeleteModal({{ $lowongan->id }}, '{{ $lowongan->posisi }}')" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>

                                        {{-- Form DELETE tersembunyi untuk proses penghapusan --}}
                                        <form id="deleteForm-{{ $lowongan->id }}" action="{{ route('perusahaan.lowongan.destroy', $lowongan->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- 🔥 Bagian PENTING: Link Pagination 🔥 --}}
                <div class="mt-4">
                    {{ $lowongans->links() }}
                </div>
            @else
                {{-- Jika tidak ada lowongan yang ditemukan --}}
                <div class="alert alert-info bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <p class="font-bold">Belum ada lowongan.</p>
                    <p class="text-sm">Silakan buat lowongan baru untuk ditampilkan di sini.</p>
                </div>
            @endif
        </div>
    </div>

@endsection

{{-- 
    ====================================================================
    MODAL 1: MODAL SUKSES (setelah create/edit/update)
    ====================================================================
--}}
@if (session('success'))
<div id="successModal" class="modal-overlay">
    <div class="success-modal-box">
        <i class="fas fa-check-circle modal-icon"></i>
        <h4 class="modal-title">Lowongan Berhasil Diproses!</h4>
        <p class="modal-message">{{ session('success') }}</p>
        <button class="modal-close-btn" onclick="closeSuccessModal()">Oke</button>
    </div>
</div>
@endif


{{-- 
    ====================================================================
    MODAL 2: MODAL KONFIRMASI HAPUS
    ====================================================================
--}}
<div id="deleteConfirmationModal" class="modal-overlay" style="z-index: 12000;">
    <div class="success-modal-box delete-modal-box">
        <i class="fas fa-trash-alt modal-icon delete-icon"></i>
        <h4 class="modal-title delete-title">Hapus Lowongan?</h4>
        <p class="modal-message delete-message">
            Anda yakin ingin menghapus lowongan "<strong id="lowonganPosisi"></strong>"? Aksi ini tidak dapat dibatalkan.
        </p>
        
        <div class="d-flex justify-content-center gap-3">
            <button class="modal-close-btn cancel-btn" onclick="closeDeleteModal()">Batal</button>
            <button class="modal-close-btn delete-confirm-btn" id="confirmDeleteButton" onclick="confirmDelete()">Ya, Hapus</button>
        </div>
        
        <input type="hidden" id="lowonganIdToDelete">
    </div>
</div>


@push('scripts')
<script>
    // --- VARIABEL MODAL SUKSES ---
    const successModal = document.getElementById('successModal');
    
    // --- VARIABEL MODAL HAPUS ---
    const deleteConfirmationModal = document.getElementById('deleteConfirmationModal');
    const lowonganIdToDeleteInput = document.getElementById('lowonganIdToDelete');
    const lowonganPosisiText = document.getElementById('lowonganPosisi');
    
    // =====================================================================
    // FUNGSI MODAL SUKSES
    // =====================================================================
    function closeSuccessModal() {
        if (successModal) {
            successModal.classList.remove('show');
            setTimeout(() => {
                successModal.remove();
            }, 300);
        }
    }

    // =====================================================================
    // FUNGSI MODAL HAPUS
    // =====================================================================
    
    function openDeleteModal(lowonganId, lowonganPosisi) {
        lowonganIdToDeleteInput.value = lowonganId;
        lowonganPosisiText.textContent = lowonganPosisi;
        deleteConfirmationModal.classList.add('show');
    }

    function closeDeleteModal() {
        deleteConfirmationModal.classList.remove('show');
        lowonganIdToDeleteInput.value = '';
        lowonganPosisiText.textContent = '';
    }

    function confirmDelete() {
        const id = lowonganIdToDeleteInput.value;
        if (id) {
            const form = document.getElementById('deleteForm-' + id);
            if (form) {
                form.submit();
            }
            closeDeleteModal(); 
        }
    }

    // =====================================================================
    // INITIALIZATION
    // =====================================================================
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- LOGIC MODAL SUKSES (Dipicu oleh redirect with('success')) ---
        if (successModal) {
            setTimeout(() => {
                successModal.classList.add('show');
            }, 10); 
            
            successModal.addEventListener('click', function(e) {
                if (e.target.id === 'successModal') {
                    closeSuccessModal();
                }
            });
        }
        
        // --- LOGIC MODAL HAPUS ---
        if (deleteConfirmationModal) {
            deleteConfirmationModal.addEventListener('click', function(e) {
                if (e.target.id === 'deleteConfirmationModal') {
                    closeDeleteModal();
                }
            });
        }
    });
</script>
@endpush