@extends('layouts.app')

@section('content')
<div class="container py-5">

  <h3 class="fw-bold text-success mb-4">📥 Import Data Pengguna</h3>

  <div class="card shadow-sm border-0 p-4 glass-card">

    <form method="POST" 
          action="{{ route('admin.import.store') }}" 
          enctype="multipart/form-data">
      @csrf

      <label class="fw-semibold mb-2">Pilih Peran Import</label>
      <select name="role" class="form-select mb-3" required>
        <option value="">-- Pilih Peran --</option>
        <option value="pengajar">Guru</option>
        <option value="siswa">Siswa</option>
        <option value="orangtua">Orang Tua</option>
      </select>

      <label class="fw-semibold mb-2">Upload File Excel</label>

      <div id="drop-zone" class="drop-zone mb-3 text-center">
        <i class="bi bi-cloud-upload-fill display-4 text-success"></i>
        <p class="mt-2">Seret file Excel atau klik di sini</p>
        <input type="file" name="file" id="file-input" class="d-none" 
               accept=".xlsx,.xls,.csv" required>
      </div>

      <button class="btn btn-success rounded-pill px-4" type="submit">
        🚀 Import Sekarang
      </button>

      <hr class="my-4">

      <p class="fw-semibold">📌 Download Template Excel</p>
      <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.import.template','pengajar') }}" class="btn btn-outline-success btn-sm rounded-pill">Guru</a>
        <a href="{{ route('admin.import.template','siswa') }}" class="btn btn-outline-primary btn-sm rounded-pill">Siswa</a>
        <a href="{{ route('admin.import.template','orangtua') }}" class="btn btn-outline-warning btn-sm rounded-pill">Orang Tua</a>
      </div>

    </form>

  </div>
</div>

<style>
.drop-zone {
    border: 2px dashed #59AC77;
    border-radius: 15px;
    padding: 40px;
    cursor: pointer;
    background: rgba(255,255,255,0.6);
    transition: 0.3s;
}
.drop-zone:hover {
    background: #e7f7ec;
}
.drop-zone.dragover {
    border-color: #17a673;
    background: #d1f5df;
}
.glass-card {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(8px);
}
</style>

<script>
const dropZone = document.getElementById('drop-zone');
const fileInput = document.getElementById('file-input');

dropZone.addEventListener('click', () => fileInput.click());
dropZone.addEventListener('dragover', e => {
  e.preventDefault();
  dropZone.classList.add('dragover');
});
dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
dropZone.addEventListener('drop', e => {
  e.preventDefault();
  dropZone.classList.remove('dragover');
  fileInput.files = e.dataTransfer.files;
});
</script>

@endsection
