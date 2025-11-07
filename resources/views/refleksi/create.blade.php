@extends('layouts.app')

@section('content')
<div class="container">
  <h4 class="mb-4">🖋️ Tulis Refleksi Diri</h4>

  <form method="POST" action="{{ route('student.refleksi.store') }}">
    @csrf
    <div class="mb-3">
      <label class="form-label">Isi Refleksi</label>
      <textarea name="content" rows="5" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Kirim Refleksi</button>
  </form>
</div>
@endsection
