@extends('layouts.app')

@section('content')
<div class="container">

  <h3 class="fw-bold text-success mb-4">
    ✍️ Penilaian Karakter Siswa
  </h3>

  {{-- ✅ Form action sesuai role --}}
  <form 
    action="{{ $role === 'teacher' ? route('teacher.assessments.store') : route('parent.assessments.store') }}" 
    method="POST">
    @csrf

    {{-- ✅ Pilih siswa --}}
    @if ($role === 'teacher')
      <div class="mb-3">
        <label class="form-label fw-semibold">Pilih Siswa</label>
        <select name="student_id" class="form-select" required>
          <option value="">-- Pilih Siswa --</option>
          @foreach($students as $s)
            <option value="{{ $s->id }}">{{ $s->name }}</option>
          @endforeach
        </select>
      </div>
    @else
      @if(isset($student) && $student)
        <input type="hidden" name="student_id" value="{{ $student->id }}">
        <div class="alert alert-light border d-flex align-items-center">
          <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=59AC77&color=fff&size=36"
               class="rounded-circle me-2" alt="{{ $student->name }}">
          <div>
            <div class="fw-semibold">{{ $student->name }}</div>
            <small class="text-muted">Anak yang akan dinilai</small>
          </div>
        </div>
      @else
        <div class="mb-3">
          <label class="form-label fw-semibold">Pilih Anak</label>
          <select name="student_id" class="form-select" required>
            <option value="">-- Pilih Anak --</option>
            @forelse($children as $c)
              <option value="{{ $c->id }}">{{ $c->name }}</option>
            @empty
              <option value="" disabled>Anda belum memiliki anak terdaftar</option>
            @endforelse
          </select>
        </div>
      @endif
    @endif

    {{-- ✅ Tanggal Penilaian --}}
    <div class="mb-3">
      <label class="form-label fw-semibold">Tanggal Penilaian</label>
      <input type="date" name="assessed_at" class="form-control" required>
    </div>

    {{-- ✅ Tabel Nilai Perdamaian --}}
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="bg-success text-white text-center">
          <tr>
            <th style="width: 30%">Nilai Perdamaian</th>
            <th>Indikator Penilaian</th>
            <th style="width: 140px;">Skor (1–5)</th>
          </tr>
        </thead>
        <tbody>
          @foreach($values as $value)
            @php
              $indicator = $value->indicators->first();
            @endphp
            <tr>
              {{-- ✅ Nilai Perdamaian --}}
              <td class="fw-semibold align-middle">
                {{ $value->name }}
              </td>

              {{-- ✅ Indikator sesuai role --}}
              <td>
                @if($role === 'teacher')
                  {{ $indicator?->description_school ?? '-' }}
                @else
                  {{ $indicator?->description_home ?? '-' }}
                @endif
              </td>

              {{-- ✅ Input nilai --}}
              <td class="text-center">
                <input
                  type="number"
                  name="scores[{{ $indicator?->id }}]"
                  min="1"
                  max="5"
                  class="form-control text-center"
                  required
                >
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- ✅ Tombol Simpan --}}
    <button type="submit" class="btn btn-success rounded-pill px-4 mt-3">
      💾 Simpan Penilaian
    </button>
  </form>
</div>
@endsection
