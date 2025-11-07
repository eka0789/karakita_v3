@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h4 class="fw-bold text-success mb-3">📊 Daftar Laporan Karakter Siswa</h4>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="bg-success text-white">
            <tr>
              <th>Nama</th>
              <th>Status Prediksi</th>
              <th>Rata-rata</th>
              <th>Pembaruan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reports as $r)
            <tr>
              <td>{{ $r['name'] }}</td>

              <td>
                @if($r['label'] === 'Baik')
                  <span class="badge bg-success">Baik 👍</span>
                @elseif($r['label'] === 'Cukup')
                  <span class="badge bg-warning text-dark">Cukup 😌</span>
                @else
                  <span class="badge bg-danger">Perlu Pembinaan 🔍</span>
                @endif
              </td>

              <td>
                {{ $r['avg'] ? number_format($r['avg'], 2) : '-' }}
              </td>

              <td>
                <small class="text-muted">
                  {{ $r['updated_at'] ? \Carbon\Carbon::parse($r['updated_at'])->format('d M Y') : '-' }}
                </small>
              </td>

              <td class="text-center">

                {{-- Pengajar: Bisa lihat detail laporan --}}
                @role('pengajar')
                <a href="{{ route('teacher.reports.show', $r['id']) }}"
                   class="btn btn-sm btn-outline-primary rounded-pill">
                  <i class="bi bi-eye"></i> Detail
                </a>
                @endrole

                {{-- Orangtua: TIDAK di index, hanya di dashboard parent melihat anaknya --}}
                {{-- Admin: Tidak ada aksi detail, hanya overview --}}
                @role('admin')
                <span class="badge bg-secondary">Ringkasan</span>
                @endrole

              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>
@endsection
