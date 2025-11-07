@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="fw-bold text-success mb-4">📘 Daftar Refleksi Diri</h4>

  <a href="{{ route('student.refleksi.create') }}" class="btn btn-success rounded-pill mb-3">
    <i class="bi bi-plus-circle me-1"></i> Tulis Refleksi Baru
  </a>

  @if(session('success'))
    <div class="alert alert-success rounded-pill shadow-sm">{{ session('success') }}</div>
  @endif

  @if($reflections->isEmpty())
    <div class="alert alert-info rounded-pill shadow-sm">Belum ada refleksi yang dikirim.</div>
  @else
  <div class="list-group shadow-sm rounded">
    @foreach($reflections as $r)
      <a href="{{ route('student.refleksi.show', $r->id) }}" class="list-group-item list-group-item-action">
        <div class="d-flex justify-content-between align-items-center">
          <small class="text-muted">{{ $r->created_at->format('d M Y, H:i') }}</small>
          <i class="bi bi-arrow-right text-success"></i>
        </div>
        <p class="mb-1 mt-1">{{ \Illuminate\Support\Str::limit($r->content, 100) }}</p>
      </a>
    @endforeach
  </div>
  @endif
</div>
@endsection
