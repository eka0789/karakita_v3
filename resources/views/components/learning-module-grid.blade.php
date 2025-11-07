@props(['modules'])

<div class="row g-4">
  @forelse($modules as $module)
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
      <div class="card shadow-sm border-0 h-100 overflow-hidden hover-shadow transition-all">
        {{-- Thumbnail --}}
        @php
          $isYoutube = str_contains($module->url, 'youtu');
          $thumb = $isYoutube
              ? 'https://img.youtube.com/vi/' . preg_replace('/.*v=([a-zA-Z0-9_-]+).*/', '$1', $module->url) . '/hqdefault.jpg'
              : asset('images/module-placeholder.jpg');
        @endphp
        <div class="ratio ratio-16x9">
          <img src="{{ $thumb }}" alt="{{ $module->title }}" class="object-cover w-100 h-100">
        </div>

        {{-- Konten --}}
        <div class="card-body d-flex flex-column">
          <div class="d-flex align-items-center mb-2">
            @if($module->type === 'video')
              <i class="bi bi-play-circle text-danger me-2 fs-5"></i>
            @elseif($module->type === 'artikel')
              <i class="bi bi-journal-text text-primary me-2 fs-5"></i>
            @else
              <i class="bi bi-lightbulb text-warning me-2 fs-5"></i>
            @endif
            <h6 class="fw-bold mb-0 text-truncate">{{ $module->title }}</h6>
          </div>

          <p class="text-muted small flex-grow-1" style="min-height:60px">
            {{ Str::limit($module->description, 100) }}
          </p>

          <div class="d-flex justify-content-between align-items-center mt-3">
            @php
  $badgeColor = match($module->type) {
      'video' => 'bg-danger text-white',     // 🎬 Merah terang untuk video
      'artikel' => 'bg-primary text-white',  // 📘 Biru untuk artikel
      'podcast' => 'bg-warning text-dark',   // 🎧 Kuning untuk podcast
      'latihan' => 'bg-success text-white',  // 💪 Hijau untuk latihan
      default => 'bg-light text-dark border' // fallback
  };
@endphp
<span class="badge {{ $badgeColor }}">{{ ucfirst($module->type) }}</span>

            <!-- <span class="badge bg-light text-dark border">{{ ucfirst($module->type) }}</span> -->
            <a href="{{ $module->url }}" target="_blank"
               class="btn btn-sm btn-outline-success rounded-pill">
              <i class="bi bi-box-arrow-up-right"></i> Lihat
            </a>
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12 text-center py-5">
      <p class="text-muted">Belum ada modul pembelajaran untuk saat ini.</p>
    </div>
  @endforelse
</div>

{{-- Extra Styling --}}
<style>
.hover-shadow:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 18px rgba(0,0,0,0.15);
}
.transition-all {
  transition: all .25s ease-in-out;
}

.badge {
  font-size: 0.8rem;
  letter-spacing: 0.3px;
  padding: 6px 10px;
  border-radius: 12px;
  transition: all .2s ease-in-out;
}
.badge:hover {
  transform: scale(1.1);
  box-shadow: 0 3px 8px rgba(0,0,0,0.15);
}

</style>
