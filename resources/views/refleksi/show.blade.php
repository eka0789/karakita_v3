@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold text-success mb-4">📖 Detail Refleksi</h4>

  <div class="card border-0 shadow-sm p-4">
    <blockquote class="blockquote mb-3">
      <p class="mb-0 text-secondary" style="font-size:1.1rem;">“{{ $refleksi->content }}”</p>
    </blockquote>
    <small class="text-muted">Ditulis pada {{ $refleksi->created_at->format('d M Y, H:i') }}</small>
  </div>

  <a href="{{ route('student.refleksi.index') }}" class="btn btn-outline-success rounded-pill mt-3">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>
</div>
@endsection
