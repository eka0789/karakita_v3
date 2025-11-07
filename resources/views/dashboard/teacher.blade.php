@extends('layouts.app')

@section('content')
<div class="container-fluid">

  {{-- Header --}}
  <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
    <div>
      <h2 class="fw-bold text-success" data-aos="fade-right">
        📊 Rekap Nilai Character Building
      </h2>
      <p class="text-muted" data-aos="fade-up" data-aos-delay="100">
        Lihat perkembangan karakter siswa dan beri penilaian terbaru secara berkala.
      </p>
    </div>

    {{-- ✅ Tombol Berikan Penilaian --}}
    <a href="{{ route('teacher.assessments.create') }}" 
       class="btn btn-success rounded-pill px-4 shadow-sm"
       data-aos="zoom-in">
       ⭐ Berikan Penilaian
    </a>
  </div>

  {{-- Statistik Ringkas --}}
  <div class="row g-4 mb-5">
    <div class="col-md-3" data-aos="zoom-in">
      <div class="card border-0 shadow-sm text-center p-3 h-100">
        <i class="bi bi-people display-5 text-success mb-2"></i>
        <h6>Total Siswa</h6>
        <p class="fs-3 fw-bold">{{ $data->count() }}</p>
      </div>
    </div>

    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
      <div class="card border-0 shadow-sm text-center p-3 h-100">
        <i class="bi bi-journal-check display-5 text-primary mb-2"></i>
        <h6>Total Penilaian</h6>
        <p class="fs-3 fw-bold">{{ \App\Models\Assessment::where('assessor_id', auth()->id())->count() }}</p>
      </div>
    </div>

    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
      <div class="card border-0 shadow-sm text-center p-3 h-100">
        <i class="bi bi-bar-chart-line display-5 text-warning mb-2"></i>
        <h6>Rata-rata Kelas</h6>
        <p class="fs-3 fw-bold">
          {{ $data->avg('avg_score') ? number_format($data->avg('avg_score'), 2) : '-' }}
        </p>
      </div>
    </div>

    <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
      <div class="card border-0 shadow-sm text-center p-3 h-100">
        <i class="bi bi-calendar-check-fill display-5 text-danger mb-2"></i>
        <h6>Penilaian Terakhir</h6>
        <p class="small fw-semibold text-muted">
          {{ $data->sortByDesc('last_assessed')->first()['last_assessed'] ?? '-' }}
        </p>
      </div>
    </div>
  </div>

  {{-- Daftar Nilai Siswa --}}
  <div class="card border-0 shadow-sm" data-aos="fade-up">
    <div class="card-body">
      <h5 class="fw-semibold mb-3 text-success">
        <i class="bi bi-table me-2"></i> Rekap Nilai Setiap Siswa
      </h5>

      @if($data->isEmpty())
        <div class="alert alert-info text-center rounded-pill shadow-sm py-3">
          <i class="bi bi-info-circle me-2"></i> Belum ada data penilaian!
        </div>
      @else
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="bg-success text-white">
            <tr>
              <th>No</th>
              <th>Siswa</th>
              <th>Kelas</th>
              <th>Rata-rata</th>
              <th>Jumlah</th>
              <th>Terakhir Dinilai</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $i => $row)
            <tr>
              <td>{{ $i + 1 }}</td>
              <td class="d-flex align-items-center">
                <img src="{{ isset($row['photo']) && $row['photo'] 
            ? asset('storage/'.$row['photo']) 
            : 'https://ui-avatars.com/api/?name='.urlencode($row['name']).'&background=59AC77&color=fff&size=40' }}"
     class="rounded-circle me-2 shadow-sm"
     width="40" height="40" style="object-fit:cover;">

                <span>{{ $row['name'] }}</span>
              </td>
              <td>{{ $row['class_name'] }}</td>
              <td>
                @php $avg = $row['avg_score']; @endphp
                <span class="badge 
                    {{ $avg >= 4 ? 'bg-success' : ($avg >= 3 ? 'bg-warning text-dark' : 'bg-danger') }}">
                  {{ number_format($avg,2) }}
                </span>
              </td>
              <td>{{ $row['assessments_count'] }}</td>
              <td><small class="text-muted">{{ $row['last_assessed'] }}</small></td>
              <td>
                <a href="{{ route('teacher.reports.show', $row['id']) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                  👁 Lihat
                </a>
                <a href="{{ route('reports.export.pdf', $row['id']) }}" class="btn btn-sm btn-outline-danger rounded-pill">
                  📄 PDF
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @endif
    </div>
  </div>

  {{-- Grafik --}}
  <div class="card border-0 shadow-sm mt-4" data-aos="fade-up" data-aos-delay="150">
    <div class="card-body">
      <h5 class="fw-semibold mb-3 text-primary">
        <i class="bi bi-graph-up-arrow me-2"></i> Grafik Distribusi Nilai
      </h5>
      <canvas id="teacherChart" height="110"></canvas>
    </div>
  </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('teacherChart'), {
  type: 'bar',
  data: {
    labels: {!! json_encode($data->pluck('name')) !!},
    datasets: [{
      data: {!! json_encode($data->pluck('avg_score')) !!},
      backgroundColor: {!! json_encode(
        $data->map(fn($v) => 
            $v['avg_score'] >= 4 ? '#59AC77' : ($v['avg_score'] >= 3 ? '#ffca3a' : '#dc3545')
        )
      ) !!},
      borderRadius: 10,
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: { beginAtZero: true, max: 5 }
    },
    plugins: {
      legend: { display: false }
    }
  }
});
</script>

@endsection
