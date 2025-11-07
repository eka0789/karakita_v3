@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2 class="mb-4">📈 Laporan Perkembangan Karakter: {{ $student->name }}</h2>

  <div class="mb-3">
    <strong>Email:</strong> {{ $student->email }} <br>
    <strong>Prediksi Karakter:</strong> {{ $prediction['label'] ?? '-' }} <br>
    <strong>Rata-rata Nilai:</strong> {{ $prediction['avg'] ?? '-' }}
  </div>

  @if(empty($indicators))
    <div class="alert alert-info">Belum ada data penilaian karakter untuk siswa ini.</div>
  @else
  <div class="row mb-4">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Radar Nilai Indikator (Penilaian Terakhir)</h5>
          <canvas id="radarChart" height="320"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Tren Rata-rata Nilai per Penilaian</h5>
          <canvas id="lineChart" height="320"></canvas>
        </div>
      </div>
    </div>
  </div>

  <div class="card shadow-sm mb-4">
    <div class="card-body">
      <h5 class="card-title mb-3">Riwayat Penilaian</h5>
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>Tanggal</th>
            <th>Kelas</th>
            <th>Rata-rata Skor</th>
            <th>Jumlah Indikator</th>
          </tr>
        </thead>
        <tbody>
          @foreach($assessments as $a)
          <tr>
            <td>{{ \Carbon\Carbon::parse($a->assessed_at)->format('d M Y') }}</td>
            <td>{{ $a->class_name ?? '-' }}</td>
            <td>{{ round($a->scores->avg('score'), 2) }}</td>
            <td>{{ $a->scores->count() }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @if($delta > 0)
  <span class="badge bg-success">
    👍 Meningkat {{ number_format($delta,2) }}
  </span>
@elseif($delta < 0)
  <span class="badge bg-danger">
    👀 Menurun {{ number_format(abs($delta),2) }}
  </span>
@else
  <span class="badge bg-secondary">
    ➖ Stabil
  </span>
@endif

    </div>
  </div>

  @if($recommendations->count())
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">💡 Rekomendasi Pengembangan Karakter</h5>
      <ul class="list-group">
        @foreach($recommendations as $rec)
          <li class="list-group-item">
            <strong>{{ $rec->peaceValue->name ?? 'Umum' }}</strong>:
            {{ $rec->description ?? '-' }}
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  @endif

  @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Radar Chart
  const radarCtx = document.getElementById('radarChart').getContext('2d');
  new Chart(radarCtx, {
    type: 'radar',
    data: {
      labels: {!! json_encode($indicators) !!},
      datasets: [{
        label: 'Skor',
        data: {!! json_encode($scores) !!},
        fill: true,
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
      }]
    },
    options: {
      scales: {
        r: {
          beginAtZero: true,
          min: 0,
          max: 5,
          ticks: { stepSize: 1 }
        }
      }
    }
  });

  // Line Chart
  const lineCtx = document.getElementById('lineChart').getContext('2d');
  new Chart(lineCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($chartLabels) !!},
      datasets: [{
        label: 'Rata-rata Nilai',
        data: {!! json_encode($chartValues) !!},
        fill: false,
        borderColor: 'rgb(75, 192, 192)',
        tension: 0.3
      }]
    },
    options: {
      scales: {
        y: { beginAtZero: true, min: 0, max: 5 }
      }
    }
  });
});
</script>
@endsection
