@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h3 class="mb-4">📚 Daftar Nilai Karakter</h3>

  <a href="{{ route('peacevalues.create') }}" class="btn btn-primary mb-3">+ Tambah Nilai</a>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-bordered align-middle">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Nilai</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      @forelse($peaceValues as $index => $pv)
      <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $pv->name }}</td>
        <td>{{ $pv->description ?? '-' }}</td>
        <td>
          <a href="{{ route('peacevalues.edit', $pv->id) }}" class="btn btn-sm btn-warning">Edit</a>
          <form action="{{ route('peacevalues.destroy', $pv->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin dihapus?')">Hapus</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="4" class="text-center">Belum ada data nilai karakter.</td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
