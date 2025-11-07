@extends('layouts.app')

@section('content')
<div class="container py-5" data-aos="fade-up">

    <h3 class="fw-bold text-success mb-4">⚙️ Pengaturan Profil</h3>

    @if (session('success'))
        <div class="alert alert-success text-center rounded-pill shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="card p-4 shadow-sm border-0 glass-card">
        
        @csrf
        @method('PATCH')

        <div class="text-center mb-3">
            <img id="preview-photo"
                src="{{ $user->photo ? asset('storage/'.$user->photo) : asset('images/default-avatar.png') }}" 
                class="rounded-circle shadow avatar-lg border"
                width="140" height="140"
                style="object-fit:cover;">
            <p class="small text-muted mt-2">Klik foto untuk mengganti</p>
        </div>

        <input type="file" name="photo" id="photo-input"
            class="d-none"
            accept="image/*"
            onchange="previewImage(event)">

        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Tanggal Lahir</label>
            <input type="date" name="birth_date" class="form-control" value="{{ $user->birth_date }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Alamat</label>
            <textarea name="address"
                class="form-control"
                rows="2">{{ $user->address }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Password Baru (Opsional)</label>
            <input type="password" name="password"
                class="form-control"
                placeholder="Biarkan kosong jika tidak diubah">
        </div>

        <button class="btn btn-success rounded-pill px-4" type="submit">
            💾 Simpan Perubahan
        </button>
    </form>

</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.5) !important;
        backdrop-filter: blur(12px);
        border-radius: 20px;
    }
</style>

<script>
document.getElementById('preview-photo').onclick = () => {
    document.getElementById('photo-input').click();
};

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = () => {
        document.getElementById('preview-photo').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

@endsection
