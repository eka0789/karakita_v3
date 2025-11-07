@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <h2 class="fw-bold text-success mb-4" data-aos="fade-right">🌱 Dashboard Admin</h2>
  <p class="text-muted mb-4" data-aos="fade-up">Selamat datang di <strong>KarakterKita</strong> — pusat kendali untuk mengelola data guru, siswa, dan orang tua.</p>

  {{-- Statistik Ringkas --}}
  <div class="row g-4 mb-4">
    <div class="col-md-3" data-aos="zoom-in">
      <div class="card shadow-sm border-0 text-center p-3 h-100">
        <i class="bi bi-people display-5 text-success mb-2"></i>
        <h6>Total Siswa</h6>
        <p class="fs-4 fw-bold">{{ \App\Models\User::where('role','siswa')->count() }}</p>
      </div>
    </div>
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
      <div class="card shadow-sm border-0 text-center p-3 h-100">
        <i class="bi bi-person-badge display-5 text-primary mb-2"></i>
        <h6>Total Guru</h6>
        <p class="fs-4 fw-bold">{{ \App\Models\User::where('role','pengajar')->count() }}</p>
      </div>
    </div>
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
      <div class="card shadow-sm border-0 text-center p-3 h-100">
        <i class="bi bi-people-fill display-5 text-warning mb-2"></i>
        <h6>Total Orang Tua</h6>
        <p class="fs-4 fw-bold">{{ \App\Models\User::where('role','orangtua')->count() }}</p>
      </div>
    </div>
    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
      <div class="card shadow-sm border-0 text-center p-3 h-100">
        <i class="bi bi-journal-text display-5 text-danger mb-2"></i>
        <h6>Total Penilaian</h6>
        <p class="fs-4 fw-bold">{{ \App\Models\Assessment::count() }}</p>
      </div>
    </div>
  </div>
  {{-- Akses ke Rekap Laporan Global --}}
  <div class="card border-0 shadow-sm mb-5" data-aos="fade-up">
    <div class="card-body">
      <h5 class="fw-semibold text-success mb-2">
        <i class="bi bi-bar-chart me-2"></i> Rekap Laporan Karakter Siswa
      </h5>
      <p class="text-muted small mb-3">
        Admin hanya dapat melihat ringkasan global laporan karakter siswa.
      </p>
      <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-success rounded-pill px-4">
        📊 Lihat Rekap Global
      </a>
    </div>
  </div>
  {{-- Navigasi Tabs --}}
  <ul class="nav nav-pills mb-3" id="roleTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="guru-tab" data-bs-toggle="pill" data-bs-target="#guru" type="button" role="tab">👨‍🏫 Guru</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="siswa-tab" data-bs-toggle="pill" data-bs-target="#siswa" type="button" role="tab">🧒 Siswa</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="orangtua-tab" data-bs-toggle="pill" data-bs-target="#orangtua" type="button" role="tab">👩‍👧 Orang Tua</button>
    </li>
  </ul>

  {{-- Tab Content --}}
  <div class="tab-content" id="roleTabsContent">
    {{-- Guru --}}
    <div class="tab-pane fade show active" id="guru" role="tabpanel">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold text-success"><i class="bi bi-person-badge me-2"></i>Daftar Guru</h5>
            <button type="button" class="btn btn-sm btn-success rounded-pill"
        data-bs-toggle="modal"
        data-bs-target="#addGuruModal">
  <i class="bi bi-plus-circle"></i> Tambah Guru
</button>
          </div>
          <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3 d-flex gap-2">
  <input type="hidden" name="tab" value="guru">
  <input type="text" name="search" class="form-control form-control-sm"
         placeholder="Cari guru..." value="{{ request('search') }}">
  <button class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
</form>

          <x-account-table :users="$teachers" />
        </div>
      </div>
    </div>

    {{-- Siswa --}}
    <div class="tab-pane fade" id="siswa" role="tabpanel">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold text-success"><i class="bi bi-people me-2"></i>Daftar Siswa</h5>
             <button type="button" class="btn btn-sm btn-success rounded-pill"
        data-bs-toggle="modal"
        data-bs-target="#addSiswaModal">
  <i class="bi bi-plus-circle"></i> Tambah Siswa
</button>
<form method="POST" action="{{ route('admin.assessments.import') }}"
      enctype="multipart/form-data"
      class="d-flex gap-2 mb-3">

    @csrf
    <input type="file" name="excel_file"
           accept=".xls,.xlsx,.csv"
           class="form-control form-control-sm" required>

    <button class="btn btn-success btn-sm rounded-pill">
        <i class="bi bi-upload"></i> Import Penilaian
    </button>
</form>

<a href="{{ asset('samples/template_penilaian.xlsx') }}"
   class="btn btn-outline-secondary btn-sm rounded-pill">
   📥 Download Template
</a>

          </div>
          <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3 d-flex gap-2">
  <input type="hidden" name="tab" value="siswa">
  <input type="text" name="search" class="form-control form-control-sm"
         placeholder="Cari siswa..." value="{{ request('search') }}">
  <button class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
</form>

          <x-account-table :users="$students" />
        </div>
      </div>
    </div>

    {{-- Orang Tua --}}
    <div class="tab-pane fade" id="orangtua" role="tabpanel">
      <div class="card border-0 shadow-sm">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-semibold text-success"><i class="bi bi-person-hearts me-2"></i>Daftar Orang Tua</h5>
             <button type="button" class="btn btn-sm btn-success rounded-pill"
        data-bs-toggle="modal"
        data-bs-target="#addOrangtuaModal">
  <i class="bi bi-plus-circle"></i> Tambah Orang Tua
</button>
          </div>
          <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-3 d-flex gap-2">
  <input type="hidden" name="tab" value="orangtua">
  <input type="text" name="search" class="form-control form-control-sm"
         placeholder="Cari orang tua..." value="{{ request('search') }}">
  <button class="btn btn-success btn-sm"><i class="bi bi-search"></i></button>
</form>

          <x-account-table :users="$parents" />
        </div>
      </div>
    </div>
  </div>
</div>
{{-- Modal Tambah Guru --}}
<div class="modal fade" id="addGuruModal" tabindex="-1" aria-labelledby="addGuruModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="addGuruModalLabel"><i class="bi bi-person-plus"></i> Tambah Guru</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role" value="pengajar">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan nama lengkap" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
          </div>
          <div class="mb-3">
  <label class="form-label fw-semibold">Tanggal Lahir</label>
  <input type="date" class="form-control" name="birth_date">
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Alamat</label>
  <textarea class="form-control" name="address" rows="2" placeholder="Masukkan alamat"></textarea>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Foto Profil</label>
  <input type="file" name="photo" accept="image/*" class="form-control">
</div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill px-4">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Modal Tambah Siswa --}}
<div class="modal fade" id="addSiswaModal" tabindex="-1" aria-labelledby="addSiswaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="addSiswaModalLabel"><i class="bi bi-person-plus"></i> Tambah Siswa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role" value="siswa">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
          </div>
          <div class="mb-3">
  <label class="form-label fw-semibold">Tanggal Lahir</label>
  <input type="date" class="form-control" name="birth_date">
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Alamat</label>
  <textarea class="form-control" name="address" rows="2" placeholder="Masukkan alamat"></textarea>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Foto Profil</label>
  <input type="file" name="photo" accept="image/*" class="form-control">
</div>
<div class="mb-3">
            <label class="form-label fw-semibold">Kelas</label>
            <select name="classroom_id" class="form-select" required>
              <option value="">-- Pilih Kelas --</option>
              @foreach(\App\Models\Classroom::orderBy('name')->get() as $kelas)
                  <option value="{{ $kelas->id }}">{{ $kelas->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Orang Tua</label>
            <select name="parent_id" class="form-select">
                <option value="">-- Pilih Orang Tua --</option>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
          </div>
          
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill px-4">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Modal Tambah Orang Tua --}}
<div class="modal fade" id="addOrangtuaModal" tabindex="-1" aria-labelledby="addOrangtuaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="addOrangtuaModalLabel"><i class="bi bi-person-plus"></i> Tambah Orang Tua</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role" value="orangtua">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Lengkap" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Masukkan Email" required>
          </div>
          <div class="mb-3">
  <label class="form-label fw-semibold">Tanggal Lahir</label>
  <input type="date" class="form-control" name="birth_date">
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Alamat</label>
  <textarea class="form-control" name="address" rows="2" placeholder="Masukkan alamat"></textarea>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Foto Profil</label>
  <input type="file" name="photo" accept="image/*" class="form-control">
</div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" class="form-control" name="password" placeholder="Masukkan Password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success rounded-pill px-4">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- Modal Edit User --}}
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Edit Pengguna</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="editUserForm" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <input type="hidden" name="id" id="edit-id">

          <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" class="form-control" name="name" id="edit-name" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" class="form-control" name="email" id="edit-email" required>
          </div>
          <div class="mb-3">
  <label class="form-label fw-semibold">Tanggal Lahir</label>
  <input type="date" class="form-control" name="birth_date" id="edit-birth_date">
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Alamat</label>
  <textarea class="form-control" name="address" id="edit-address" rows="2"></textarea>
</div>

<div class="mb-3">
  <label class="form-label fw-semibold">Foto Profil (opsional)</label>
  <input type="file" name="photo" accept="image/*" class="form-control">
</div>

          <div class="mb-3">
            <label class="form-label fw-semibold">Password (Opsional)</label>
            <input type="password" class="form-control" name="password"
              placeholder="Biarkan kosong jika tidak diubah">
          </div>

          <div class="mb-3 role-parent-field d-none">
            <label class="form-label fw-semibold">Orang Tua</label>
            <select name="parent_id" id="edit-parent" class="form-select">
              <option value="">-- Tidak Ada --</option>
              @foreach($parents as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
              @endforeach
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
document.querySelectorAll('.edit-user-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.dataset.id;
        document.getElementById('editUserForm').action = `/admin/users/${id}`;

        document.getElementById('edit-id').value = id;
        document.getElementById('edit-name').value = btn.dataset.name;
        document.getElementById('edit-email').value = btn.dataset.email;
        document.getElementById('edit-birth_date').value = btn.dataset.birth_date || '';
        document.getElementById('edit-address').value = btn.dataset.address || '';
        
        if (btn.dataset.role === 'siswa') {
            document.querySelector('.role-parent-field').classList.remove('d-none');
            document.getElementById('edit-parent').value = btn.dataset.parent;
            document.getElementById('edit-class').value = btn.dataset.class;
        } else {
            document.querySelector('.role-parent-field').classList.add('d-none');
        }
    });
});


</script>


@endsection
