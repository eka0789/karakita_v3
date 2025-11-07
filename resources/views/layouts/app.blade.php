<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'KARAKTERKITA Dashboard' }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f7fa;
      color: #333;
    }

    /* NAVBAR */
    .navbar {
      background: #ffffff;
      box-shadow: 0 3px 10px rgba(0,0,0,0.05);
      position: sticky;
      top: 0;
      z-index: 1030;
    }

    .navbar-brand {
      color: #003049 !important;
      font-weight: 700;
    }

    .navbar-brand span { color: #59AC77; }

    /* SIDEBAR */
    .sidebar {
      width: 250px;
      position: fixed;
      top: 56px;
      left: 0;
      height: 100%;
      background: linear-gradient(180deg, #59AC77 0%, #3c8060 100%);
      color: #fff;
      transition: all 0.3s ease;
    }

    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      font-weight: 500;
      transition: background 0.3s ease;
    }

    .sidebar a:hover, .sidebar a.active {
      background: rgba(255,255,255,0.15);
      border-left: 4px solid #ffca3a;
    }

    /* CONTENT AREA */
    .content {
      margin-left: 250px;
      padding: 2rem;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    footer {
      background: #003049;
      color: #fff;
      text-align: center;
      padding: 1rem;
      border-top: 4px solid #59AC77;
      margin-top: 2rem;
    }

    @media (max-width: 991px) {
      .sidebar { position: relative; width: 100%; height: auto; }
      .content { margin-left: 0; }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{ url('/') }}">
        KARAKTER<span>KITA</span>
      </a>
      <div class="ms-auto d-flex align-items-center">
        <span class="me-3 text-muted small">Hi, {{ Auth::user()->name ?? 'User' }}</span>
        <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </div>
    </div>
  </nav>

  <!-- SIDEBAR -->
<div class="sidebar">

  {{-- Dashboard sesuai role --}}
  @role('admin')
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>
  @endrole

  @role('pengajar')
    <a href="{{ route('teacher.dashboard') }}" class="{{ request()->is('pengajar/dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>
  @endrole

  @role('orangtua')
    <a href="{{ route('parent.dashboard') }}" class="{{ request()->is('orangtua/dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>
  @endrole

  @role('siswa')
    <a href="{{ route('student.dashboard') }}" class="{{ request()->is('siswa/dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>
  @endrole

  @role('pengajar')
<a href="{{ route('teacher.assessments.create') }}" 
   class="{{ request()->is('pengajar/assessments*') ? 'active' : '' }}">
   <i class="bi bi-pencil-square me-2"></i> Penilaian
</a>
@endrole

@role('orangtua')
<a href="{{ route('parent.assessments.create') }}"
   class="{{ request()->is('orangtua/assessments*') ? 'active' : '' }}">
   <i class="bi bi-check2-square me-2"></i> Penilaian
</a>
@endrole



  {{-- Menu Laporan --}}
  @role('admin')
    <a href="{{ route('admin.reports.index') }}" class="{{ request()->is('admin/reports*') ? 'active' : '' }}">
      <i class="bi bi-bar-chart me-2"></i> Laporan
    </a>
  @endrole

  @role('admin')
    <a href="{{ route('admin.import.index') }}" 
       class="{{ request()->is('admin/import*') ? 'active' : '' }}">
      <i class="bi bi-upload me-2"></i> Import Pengguna
    </a>
@endrole


  @role('pengajar')
    <a href="{{ route('teacher.reports.index') }}" class="{{ request()->is('pengajar/reports*') ? 'active' : '' }}">
      <i class="bi bi-bar-chart me-2"></i> Laporan
    </a>
  @endrole

  @role('orangtua')
    {{-- Orangtua langsung ke laporan anak --}}
    <a href="{{ route('parent.dashboard') }}" class="{{ request()->is('orangtua/reports*') ? 'active' : '' }}">
      <i class="bi bi-graph-up-arrow me-2"></i> Laporan Anak
    </a>
  @endrole


  {{-- Menu Refleksi Khusus Siswa --}}
  @role('siswa')
    <a href="{{ route('student.refleksi.index') }}" class="{{ request()->is('siswa/refleksi*') ? 'active' : '' }}">
      <i class="bi bi-journal-text me-2"></i> Refleksi
    </a>
  @endrole

    {{-- ✅ Pengaturan Profil (Semua user) --}}
  <a href="{{ route('profile.edit') }}" 
     class="{{ request()->is('profile') ? 'active' : '' }}">
      <i class="bi bi-person-gear me-2"></i> Pengaturan Profil
  </a>

</div>


  <!-- MAIN CONTENT -->
  <div class="content">
    @yield('content')
    @if(session('success'))
  <div class="alert alert-success text-center rounded-pill shadow-sm mx-4 mt-3">
    {{ session('success') }}
  </div>
@endif

  </div>

  <footer>
    <p>© 2025 KARAKTERKITA - Rumah Cerdas KITA</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init({ duration: 800, once: true });</script>
</body>
</html>
