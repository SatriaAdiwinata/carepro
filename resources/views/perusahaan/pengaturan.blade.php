@extends('layouts.master')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan')

@section('content')
<!-- Pengaturan Section -->
<div id="pengaturan" class="content-section active">
    <!-- View Mode -->
    <div id="pengaturan-view" class="card">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h3 class="card-title">Pengaturan Akun</h3>
            <button class="btn btn-primary" onclick="editPengaturan()">
                <i class="fas fa-edit"></i> Edit Pengaturan
            </button>
        </div>
        <div style="padding: 20px;">
            <div style="display: grid; gap: 20px;">
                <div style="padding: 20px; background: #f8fafc; border-radius: 10px;">
                    <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Email Notifikasi</div>
                    <div style="font-weight: 600; font-size: 16px;">{{ $emailNotifikasi ?? 'hr@teknologimaju.com' }}</div>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 10px;">
                    <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Password</div>
                    <div style="font-weight: 600; font-size: 16px;">••••••••••</div>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 10px;">
                    <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Notifikasi Email</div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        @if($terimaNotifikasi ?? true)
                            <span class="badge badge-active">Aktif</span>
                            <span style="color: #64748b;">Menerima notifikasi lamaran baru</span>
                        @else
                            <span class="badge badge-inactive">Nonaktif</span>
                            <span style="color: #64748b;">Tidak menerima notifikasi</span>
                        @endif
                    </div>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 10px;">
                    <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Notifikasi Desktop</div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span class="badge badge-active">Aktif</span>
                        <span style="color: #64748b;">Notifikasi push untuk aktivitas penting</span>
                    </div>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 10px;">
                    <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Bahasa</div>
                    <div style="font-weight: 600; font-size: 16px;">Bahasa Indonesia</div>
                </div>

                <div style="padding: 20px; background: #f8fafc; border-radius: 10px;">
                    <div style="color: #64748b; font-size: 14px; margin-bottom: 8px;">Zona Waktu</div>
                    <div style="font-weight: 600; font-size: 16px;">WIB (GMT+7)</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Mode -->
    <div id="pengaturan-edit" class="card" style="display: none;">
        <div class="card-header">
            <h3 class="card-title">Edit Pengaturan Akun</h3>
        </div>
        <form action="{{ route('perusahaan.pengaturan') }}" method="POST" onsubmit="savePengaturan(event)">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">Email Notifikasi</label>
                <input type="email" class="form-input" id="edit-email" name="email_notifikasi" value="{{ $emailNotifikasi ?? 'hr@teknologimaju.com' }}">
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" class="form-input" id="edit-password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-input" id="edit-confirm-password" name="password_confirmation" placeholder="Konfirmasi password baru">
            </div>

            <div class="form-group">
                <label class="form-label">Notifikasi Email</label>
                <div style="padding: 15px; background: #f8fafc; border-radius: 8px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="edit-notif-email" name="terima_notifikasi" {{ ($terimaNotifikasi ?? true) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                        <span>Terima notifikasi lamaran baru via email</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Notifikasi Desktop</label>
                <div style="padding: 15px; background: #f8fafc; border-radius: 8px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="edit-notif-desktop" checked style="width: 18px; height: 18px;">
                        <span>Terima notifikasi push untuk aktivitas penting</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Bahasa</label>
                <select class="form-input" id="edit-bahasa" name="bahasa">
                    <option value="id" selected>Bahasa Indonesia</option>
                    <option value="en">English</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Zona Waktu</label>
                <select class="form-input" id="edit-timezone" name="timezone">
                    <option value="wib" selected>WIB (GMT+7)</option>
                    <option value="wita">WITA (GMT+8)</option>
                    <option value="wit">WIT (GMT+9)</option>
                </select>
            </div>

            <div class="action-buttons" style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <button type="button" class="btn btn-secondary" onclick="cancelEditPengaturan()">
                    <i class="fas fa-times"></i> Batal
                </button>
            </div>
        </form>
    </div>
</div>


<script>
 // Pengaturan Functions
        function editPengaturan() {
            document.getElementById('pengaturan-view').style.display = 'none';
            document.getElementById('pengaturan-edit').style.display = 'block';
        }

        function cancelEditPengaturan() {
            document.getElementById('pengaturan-view').style.display = 'block';
            document.getElementById('pengaturan-edit').style.display = 'none';
        }

        function savePengaturan(e) {
            e.preventDefault();
            alert('Pengaturan berhasil disimpan!');
            cancelEditPengaturan();
        }
</script>
@endsection
