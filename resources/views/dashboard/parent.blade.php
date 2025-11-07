@extends('layouts.app')

@section('content')
<div class="container-fluid">

  {{-- Header --}}
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
    <div>
      <h2 class="fw-bold text-success" data-aos="fade-right">
        👨‍👩‍👧 Dashboard Orang Tua
      </h2>
      <p class="text-muted" data-aos="fade-up" data-aos-delay="100">
        Selamat datang, <strong>{{ $user->name }}</strong> 👋  
        Pantau & dukung perkembangan karakter anak Anda.
      </p>
    </div>

    {{-- ✅ Tombol Berikan Penilaian --}}
    <a href="{{ route('parent.assessments.create') }}"
       class="btn btn-success rounded-pill px-4 shadow-sm"
       data-aos="zoom-in">
       ⭐ Berikan Penilaian
    </a>
  </div>

  {{-- Jika Tidak Ada Anak --}}
  @if($childrenData->isEmpty())
  <div class="alert alert-warning rounded-pill border-0 text-center py-3 shadow-sm" data-aos="fade-up">
    <i class="bi bi-info-circle"></i> Belum ada siswa terhubung dengan akun Anda.
  </div>
  @endif

  {{-- Loop Data Anak --}}
  @foreach($childrenData as $i => $child)
  <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
    <div class="card-body">

      {{-- Info Anak --}}
      <div class="d-flex align-items-center mb-3">
       <img src="{{ isset($child['photo']) && $child['photo'] 
            ? asset('storage/'.$child['photo']) 
            : 'https://ui-avatars.com/api/?name='.urlencode($child['name']).'&background=59AC77&color=fff&size=60' }}"
     class="rounded-circle shadow-sm me-3"
     width="60" height="60"
     style="object-fit:cover;">

        <div>
          <h5 class="fw-bold mb-0">{{ $child['name'] }}</h5>
         <small class="text-muted">Kelas {{ $child['class']['name'] ?? '-' }}</small>
        </div>
      </div>

      {{-- Prediksi Status --}}
      @if($child['prediction'])
      <p class="small mb-1 text-muted">Status Karakter</p>
      <span class="badge px-3 py-2
        @if($child['prediction']['label']=='Baik') bg-success 
        @elseif($child['prediction']['label']=='Cukup') bg-warning text-dark
        @else bg-danger @endif">
        {{ $child['prediction']['label'] }}
      </span>
      <small class="ms-2 text-muted">
        Rata-rata: {{ number_format($child['prediction']['avg'],2) }}
      </small>

      <div class="mt-3 d-flex gap-2">
        {{-- Lihat Laporan --}}
        <a href="{{ route('parent.reports.show', $child['id']) }}" 
           class="btn btn-outline-success btn-sm rounded-pill">
          📊 Lihat Laporan
        </a>

        {{-- ✅ Akses Penilaian --}}
        <a href="{{ route('parent.assessments.create', ['student_id' => $child['id']]) }}"
           class="btn btn-sm btn-success rounded-pill">
          ⭐ Nilai Sekarang
        </a>
      </div>
      @else
        <p class="text-muted small mb-2">
          ❌ Belum ada penilaian untuk anak ini.
        </p>
        <a href="{{ route('parent.assessments.create', ['student_id' => $child['id']]) }}"
           class="btn btn-success btn-sm rounded-pill">
          ⭐ Berikan Penilaian Perdana
        </a>
      @endif

      {{-- ✅ Rekomendasi --}}
      @if(!$child['recommendations']->isEmpty())
      <hr class="my-3">
      <p class="fw-semibold text-primary mb-2">💡 Rekomendasi Pembinaan</p>
      <ul class="list-group list-group-flush">
        @foreach($child['recommendations']->take(3) as $r)
        <li class="list-group-item px-0 border-0">
          <strong class="text-dark">{{ $r->peaceValue->name }}</strong>
          <p class="small text-muted mb-0">{{ $r->description }}</p>
        </li>
        @endforeach
      </ul>
      @endif

    </div>
  </div>
  @endforeach


  {{-- ✅ Modul Pembelajaran Karakter --}}
  @if(!$modules->isEmpty())
  <div class="card border-0 shadow-sm mt-5" data-aos="fade-up">
    <div class="card-body">
      <h5 class="fw-bold mb-3 text-primary">
        📚 Modul Pembelajaran Pendukung
      </h5>

      <div class="row g-3">
        @foreach($modules as $m)
        <div class="col-md-4">
          <div class="card border-0 shadow-sm h-100 p-3">
            <h6 class="fw-bold">{{ $m->title }}</h6>
            <p class="text-muted small">{{ Str::limit($m->description, 90) }}</p>
            <a href="{{ $m->url }}" target="_blank"
               class="btn btn-sm btn-outline-primary rounded-pill">
               ▶ Buka Modul
            </a>
          </div>
        </div>
        @endforeach
      </div>

    </div>
  </div>
  @endif

</div>
@endsection
