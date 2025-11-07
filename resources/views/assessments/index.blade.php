@extends('layouts.app')
@section('content')
<div class="container mx-auto py-6">
  <h1 class="text-xl font-bold mb-4">Riwayat Penilaian</h1>

  <table class="table-auto w-full border">
    <thead>
      <tr class="bg-gray-100">
        <th class="px-3 py-2">Tanggal</th>
        <th class="px-3 py-2">Siswa</th>
        <th class="px-3 py-2">Peran</th>
        <th class="px-3 py-2">Aksi</th>
      </tr>
    </thead>
    <tbody>
      @foreach($assessments as $a)
        <tr class="border-t">
          <td class="px-3 py-2">{{ \Carbon\Carbon::parse($a->assessed_at)->format('d M Y') }}</td>
          <td class="px-3 py-2">{{ $a->student->name }}</td>
          <td class="px-3 py-2">{{ ucfirst($a->source) }}</td>
          <td class="px-3 py-2">
            <a href="{{ route('assessments.show', $a) }}" class="text-blue-600">Detail</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
