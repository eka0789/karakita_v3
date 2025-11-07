@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <h2 class="fw-bold text-success mb-4" data-aos="fade-right">
    🌿 Dashboard Siswa
  </h2>

  {{-- Prediksi Karakter --}}
  @if($prediction)
  <div class="card border-0 shadow-sm mb-4" data-aos="zoom-in">
    <div class="card-body text-center">
      <i class="bi bi-bar-chart-line text-success display-5 mb-2"></i>
      <h5 class="fw-semibold">Prediksi Sistem</h5>
      <p>Status Karakter: 
        <span class="badge bg-{{ $prediction['label'] === 'Baik' ? 'success' : ($prediction['label'] === 'Cukup' ? 'warning' : 'danger') }} fs-6 px-3 py-2">
          {{ strtoupper($prediction['label']) }}
        </span>
      </p>
      <p class="text-muted small mb-0">Rata-rata Nilai: {{ number_format($prediction['avg'], 2) }}</p>
    </div>
  </div>
  @endif

  {{-- Grafik Perkembangan --}}
  <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
    <div class="card-body">
      <h5 class="fw-semibold mb-3"><i class="bi bi-graph-up-arrow me-2 text-success"></i> Grafik Perkembangan Karakter</h5>
      <canvas id="chart" height="90"></canvas>
    </div>
  </div>

  {{-- Rekomendasi Pengembangan --}}
  <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="card-body">
      <h5 class="fw-semibold mb-3"><i class="bi bi-lightbulb me-2 text-warning"></i> Rekomendasi Pengembangan</h5>
      @if($recommendations->isEmpty())
        <p class="text-muted">Belum ada rekomendasi untukmu saat ini 🌱</p>
      @else
        <div class="list-group list-group-flush">
          @foreach($recommendations as $r)
            <div class="list-group-item border-0 border-bottom py-2">
              <b>{{ $r->peaceValue->name }}</b> — <span class="text-muted">{{ $r->description }}</span>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>

  {{-- Modul Pembelajaran --}}
  <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="200">
    <div class="card-body">
      <h5 class="fw-semibold mb-3"><i class="bi bi-book me-2 text-primary"></i> Modul Pembelajaran Karakter</h5>
      <x-learning-module-grid :modules="$modules" />
    </div>
  </div>

{{-- Akses Refleksi --}}
<div class="card border-0 shadow-sm mb-5" data-aos="fade-up" data-aos-delay="250">
  <div class="card-body text-center">
    <h5 class="fw-semibold mb-3"><i class="bi bi-journal-text me-2 text-success"></i> Refleksi Diri</h5>
    <p class="text-muted small mb-3">Tuliskan hal positif yang kamu pelajari hari ini untuk memperkuat karaktermu.</p>

    <a href="{{ route('student.refleksi.create') }}" class="btn btn-success rounded-pill px-4">
      ✏️ Tulis Refleksi Baru
    </a>
    <a href="{{ route('student.refleksi.index') }}" class="btn btn-outline-secondary rounded-pill ms-2">
      📖 Lihat Refleksi Kamu
    </a>
  </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chart'), {
  type: 'line',
  data: {
    labels: {!! json_encode($chartLabels) !!},
    datasets: [{
      label: 'Rata-rata Skor',
      data: {!! json_encode($chartValues) !!},
      borderWidth: 2,
      fill: true,
      backgroundColor: 'rgba(89,172,119,0.2)',
      borderColor: '#59AC77',
      tension: .3,
      pointRadius: 4,
      pointHoverRadius: 6,
    }]
  },
  options: {
    scales: {
      y: { beginAtZero:true, max:5 },
      x: { ticks: { color:'#555' } }
    },
    plugins: { legend: { display: false } }
  }
});
</script>
@endsection
