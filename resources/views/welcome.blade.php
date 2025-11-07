<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>KARAKTERKITA - Rumah Cerdas KITA</title>

  <!-- Bootstrap & AOS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      background: #f9fbfd;
      scroll-behavior: smooth;
    }

    /* === Navbar === */
    nav {
      background: rgba(255, 255, 255, 0.95);
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      backdrop-filter: blur(8px);
    }

    .navbar-brand {
      color: #003049 !important;
      font-weight: 700;
    }

    .nav-link {
      color: #003049 !important;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #1a73e8 !important;
    }

    /* === Hero Section === */
    header {
      position: relative;
      height: 100vh;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      background: linear-gradient(120deg, rgba(135,206,250,0.8), rgba(152,251,152,0.8)), 
        url('{{ asset('images/rumahcerdaskita.jpg') }}') no-repeat center center / cover;
      background-attachment: fixed;
    }

    header::after {
      content: "";
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 80px;
      background: url('https://www.svgrepo.com/show/21782/wave.svg') no-repeat bottom center;
      background-size: cover;
    }

    header h1 {
      font-weight: 700;
      font-size: 3.5rem;
      text-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    header p {
      font-size: 1.3rem;
      max-width: 700px;
      margin: 1.5rem auto;
      text-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .btn-custom {
      background-color: #ffca3a;
      border-radius: 50px;
      padding: 0.8rem 2.5rem;
      font-weight: 600;
      color: #333;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #f9a826;
      color: #fff;
      transform: translateY(-3px) scale(1.05);
    }

    /* === Bubbles === */
    .bubbles {
      position: absolute;
      width: 100%;
      height: 100%;
      overflow: hidden;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .bubble {
      position: absolute;
      bottom: -50px;
      background: rgba(255,255,255,0.7);
      border-radius: 50%;
      animation: rise 10s infinite ease-in;
    }

    @keyframes rise {
      0% { transform: translateY(0) scale(1); opacity: 0.8; }
      100% { transform: translateY(-1200px) scale(0.5); opacity: 0; }
    }

    section {
      padding: 6rem 0;
    }

    h2 {
      font-weight: 700;
      color: #003049;
      position: relative;
      display: inline-block;
      margin-bottom: 3rem;
    }

    h2::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: #ffca3a;
    }

    .feature-card {
      border-radius: 1.5rem;
      background: #fff;
      box-shadow: 0 6px 15px rgba(0,0,0,0.07);
      transition: all 0.3s ease;
      padding: 2rem;
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .feature-card i {
      transition: transform 0.3s ease;
    }

    .feature-card:hover i {
      transform: scale(1.2);
    }

    /* === Nilai Section === */
    .nilai-item {
      background: #fff;
      border-radius: 1.5rem;
      padding: 1.5rem;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
      height: 100%;
    }

    .nilai-item:hover {
      transform: translateY(-5px);
      background: linear-gradient(145deg, #fefefe, #f2f9ff);
    }

    .nilai-item img {
      height: 150px;
      object-fit: cover;
    }

    /* === TESTIMONI SECTION === */
#testimoni {
  padding: 80px 0;
  background-color: #f9f9f9;
}

#testimoni h2 {
  font-weight: 700;
  margin-bottom: 40px;
}

.testimonial-card {
  background: #fff;
  border-radius: 16px;
  padding: 30px 20px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease;
  height: 100%;
}

.testimonial-card:hover {
  transform: translateY(-5px);
}

/* --- FOTO TESTIMONI --- */
.testimonial-card img {
  width: 120px;
  height: 120px;
  object-fit: cover; /* menjaga proporsi */
  border-radius: 50%; /* bikin bulat sempurna */
  margin-bottom: 20px;
  border: 4px solid #f1f1f1;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* --- TEKS --- */
.testimonial-card p {
  font-style: italic;
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 15px;
  line-height: 1.6;
}

.testimonial-card h6 {
  font-weight: 600;
  color: #333;
  margin-bottom: 0;
}
@media (max-width: 768px) {
  .testimonial-card img {
    width: 100px;
    height: 100px;
  }
}


 /* === POSTER PENDAFTARAN === */
#pendaftaran {
  background: linear-gradient(135deg, #2c6e49, #59ac77);
  color: #fff;
}

.poster-card {
  width: 100%;
  max-width: 450px; /* poster lebih proporsional */
  background: #fff;
  border: 6px solid #fff;
  border-radius: 16px;
  overflow: hidden;
  transition: transform 0.3s ease;
}

.poster-card:hover {
  transform: scale(1.02);
}

.poster-img {
  width: 100%;
  height: auto;
  object-fit: contain; /* jaga rasio asli gambar */
  display: block;
}

/* Responsive layout */
@media (max-width: 992px) {
  #pendaftaran .row {
    text-align: center;
  }

  .poster-card {
    max-width: 350px;
    margin-top: 20px;
  }

  #pendaftaran ul {
    list-style: none;
    padding: 0;
  }

  #pendaftaran ul li::before {
    content: "• ";
    color: #ffd700;
  }
}


    /* === Kontak === */
    #kontak {
      background: linear-gradient(135deg, #003049, #004d7a);
      color: #fff;
    }

    .contact-info {
      background: rgba(255,255,255,0.1);
      padding: 2rem;
      border-radius: 1rem;
    }

    .map-container {
      height: 100%;
      border-radius: 1rem;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .map-container iframe {
      width: 100%;
      height: 100%;
      border: 0;
    }

    /* Social Media Links */
    .social-media a {
      color: #fff;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .social-media a:hover {
      color: #ffca3a;
    }

    .social-media i {
      margin-right: 0.5rem;
    }

    /* === WA Chat Button === */
    .wa-chat {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 1000;
    }

    .wa-chat a {
      background-color: #25D366;
      color: #fff;
      font-size: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      transition: all 0.3s ease;
    }

    .wa-chat a:hover {
      background-color: #20b857;
      transform: scale(1.1) rotate(5deg);
    }

    /* === Back to Top === */
    .back-to-top {
      position: fixed;
      bottom: 20px;
      left: 20px;
      z-index: 1000;
      background: #ffca3a;
      color: #333;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 50%;
      opacity: 0;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .back-to-top.show {
      opacity: 1;
    }

    .back-to-top:hover {
      background: #f9a826;
      color: #fff;
      transform: translateY(-5px);
    }

    /* Glassmorphism Team Card */
.glass-card {
  background: rgba(255, 255, 255, 0.35);
  border-radius: 20px;
  backdrop-filter: blur(14px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  border: 1px solid rgba(255,255,255,0.25);
  transition: transform .3s ease, box-shadow .3s ease;
}

.glass-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}

/* Profile Image Circle with Glow */
.team-img-wrapper {
  width: 130px;
  height: 130px;
  border-radius: 50%;
  padding: 5px;
  background: linear-gradient(135deg, #73ffa8, #59ac77, #4f9f8e);
  display: flex;
  align-items: center;
  justify-content: center;
  transition: 0.4s;
}
.team-img-wrapper:hover {
  filter: brightness(1.15);
}

.team-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

/* Swiper sizing */
.mySwiper .swiper-slide {
  display: flex;
  justify-content: center;
}

.swiper-button-next,
.swiper-button-prev {
  color: #59ac77;
}
.swiper-pagination-bullet-active {
  background: #59ac77 !important;
}

.card ul {
  list-style-type: disc;
  padding-left: 1.2rem;
}

.icon-circle {
  box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.card {
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 18px rgba(0,0,0,0.15);
}


/* Glassmorphism Feature Cards */ 
.glass-kita {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    transition: 0.3s ease-in-out;
  }
  .glass-kita:hover {
    transform: translateY(-6px) scale(1.03);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
  }
  .icon-circle {
    width: 60px;
    height: 60px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size: 24px;
    border-radius:50%;
    margin:auto;
  }

/* TIM PENGAJAR */
.teacher-img {
  width: 150px;
  height: 150px;
  object-fit: cover;
  object-position: center;
  border-radius: 50%;
  border: 4px solid rgba(255,255,255,0.8);
  background: #fff;
  padding: 3px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  transition: all 0.35s ease-in-out;
}

.teacher-card {
  border-radius: 18px;
  background: rgba(255, 255, 255, 0.4);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border: 1px solid rgba(255,255,255,0.4);
  transition: transform .3s, box-shadow .3s;
}

.teacher-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.18);
}

.teacher-card:hover .teacher-img {
  transform: scale(1.07);
}

/* === FAQ Accordion Styling (Full Width Button Fixed) === */
#faq .accordion-item {
  border: none;
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  transition: all 0.3s ease;
}

#faq .accordion-item:not(:last-child) {
  margin-bottom: 1rem;
}

#faq .accordion-header {
  margin: 0;
  padding: 0;
  width: 100%;
}

#faq .accordion-button {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  min-height: 100%;
  background-color: #e9f2ff;
  color: #003049;
  font-weight: 600;
  border: none;
  box-shadow: none;
  border-radius: 0;
  padding: 1.25rem 1.75rem;
  text-align: left;
  transition: all 0.3s ease;
}

#faq .accordion-button:hover {
  background-color: #d6e8ff;
}

#faq .accordion-button:not(.collapsed) {
  background-color: #dceeff;
  color: #003049;
}

/* ✅ Remove any space between button & header edges */
#faq .accordion-header .accordion-button {
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
}

/* Chevron Icon at far right */
#faq .accordion-button::after {
  all: unset;
  font-family: "Bootstrap-icons";
  content: "\F285"; /* chevron-down */
  font-size: 1.2rem;
  color: #003049;
  margin-left: auto;
  transition: transform 0.3s ease;
}

#faq .accordion-button:not(.collapsed)::after {
  content: "\F282"; /* chevron-up */
  transform: rotate(0deg);
}

/* Accordion Body */
#faq .accordion-body {
  background-color: #fff;
  color: #555;
  font-size: 0.95rem;
  line-height: 1.7;
  padding: 1.25rem 1.75rem;
  border-top: 2px solid #ffca3a;
  border-bottom-left-radius: 16px;
  border-bottom-right-radius: 16px;
}

/* Hover Elevation */
#faq .accordion-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
}

/* Responsive Tweaks */
@media (max-width: 576px) {
  #faq .accordion-button {
    font-size: 0.95rem;
    padding: 1rem 1.25rem;
  }
  #faq .accordion-body {
    padding: 1rem 1.25rem;
  }
}
/* gallery */
 .gallery-card {
    width: 100%;
    max-width: 380px;
    aspect-ratio: 16/10;
    background-color: #eee;
    transition: .3s ease-in-out;
    border-radius: 18px;
  }

  .gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .35s;
  }

  .gallery-card:hover .gallery-img {
    transform: scale(1.07);
    filter: brightness(1.08);
  }

@media (max-width: 576px) {
  .teacher-img {
    width: 120px;
    height: 120px;
  }
}

    footer {
      background: #003049;
      color: #fff;
      padding: 2rem 0;
      text-align: center;
    }
  </style>
</head>

<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">KARAKTER<span style="color:red;">KITA</span></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a href="#tentang" class="nav-link">Tentang</a></li>
          <li class="nav-item"><a href="#fitur" class="nav-link">Fitur</a></li>
          <li class="nav-item"><a href="#nilai" class="nav-link">Nilai Perdamaian</a></li>
          <li class="nav-item"><a href="#testimoni" class="nav-link">Testimoni</a></li>
          <li class="nav-item"><a href="#program" class="nav-link">Program</a></li>
          <li class="nav-item"><a href="#kontak" class="nav-link">Kontak</a></li>
          <!-- ✅ Tombol Login -->
          <li class="nav-item ms-lg-3">
            <a href="{{ route('login') }}" class="btn btn-success rounded-pill px-4">
              <i class="bi bi-box-arrow-in-right me-1"></i> Login
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <header>
    <div class="bubbles">
      <div class="bubble" style="left:5%;width:20px;height:20px;animation-duration:12s;"></div>
      <div class="bubble" style="left:15%;width:15px;height:15px;animation-delay:2s;animation-duration:15s;"></div>
      <div class="bubble" style="left:30%;width:25px;height:25px;animation-delay:4s;"></div>
      <div class="bubble" style="left:45%;width:10px;height:10px;animation-delay:1s;animation-duration:10s;"></div>
      <div class="bubble" style="left:60%;width:18px;height:18px;animation-delay:3s;"></div>
      <div class="bubble" style="left:75%;width:22px;height:22px;animation-delay:5s;animation-duration:14s;"></div>
      <div class="bubble" style="left:90%;width:12px;height:12px;animation-delay:0s;"></div>
    </div>
    <div class="container position-relative z-3">
      <h1 data-aos="fade-up">Rumah Cerdas KITA</h1>
      <p data-aos="fade-up" data-aos-delay="200">Membentuk karakter damai, mandiri, dan berempati melalui teknologi pembelajaran interaktif yang inovatif dan menyenangkan.</p>
      <a href="#fitur" class="btn btn-custom mt-3" data-aos="zoom-in" data-aos-delay="400">Jelajahi Sekarang</a>
    </div>
  </header>

  <!-- TENTANG -->
  <section id="tentang" class="bg-light" data-aos="fade-up">
    <div class="container text-center">
      <h2 class="mb-5">Tentang KARAKTER<span style="color:red;">KITA</span></h2>
      <p class="lead mb-4"><strong>KARAKTER<span style="color:red;">KITA</span></strong> adalah platform inovatif yang dirancang untuk membantu guru, orang tua, dan siswa dalam membangun karakter positif. Dengan integrasi teknologi AI dan machine learning, kami menyediakan alat untuk memantau, memprediksi, dan meningkatkan karakter anak secara kolaboratif.</p>
      <div class="row justify-content-center">
        <div class="col-md-8">
          <img src="{{ asset('images/kegiatan2.jpeg') }}" class="img-fluid rounded shadow" alt="Tentang Kami">
        </div>
      </div>
    </div>
  </section>

  <!-- FITUR -->
  <section id="fitur" data-aos="fade-up">
    <div class="container text-center">
      <h2 class="mb-5">Fitur Unggulan KARAKTER<span style="color:red;">KITA</span></h2>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card">
            <i class="bi bi-person-check display-4 text-primary mb-3"></i>
            <h5 class="mt-3">Manajemen Pengguna</h5>
            <p>Login multi-role: Admin, Guru, Orangtua, dan Siswa dengan akses yang disesuaikan.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card">
            <i class="bi bi-bar-chart display-4 text-success mb-3"></i>
            <h5 class="mt-3">Laporan & Prediksi</h5>
            <p>Prediksi karakter berbasis Machine Learning (Random Forest) untuk intervensi dini.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-card">
            <i class="bi bi-heart display-4 text-warning mb-3"></i>
            <h5 class="mt-3">Rekomendasi Karakter</h5>
            <p>Saran otomatis bagi guru & orangtua untuk penguatan karakter yang personal.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card">
            <i class="bi bi-chat-dots display-4 text-info mb-3"></i>
            <h5 class="mt-3">Komunikasi Kolaboratif</h5>
            <p>Forum diskusi dan notifikasi real-time untuk kolaborasi antara guru dan orang tua.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card">
            <i class="bi bi-shield-lock display-4 text-danger mb-3"></i>
            <h5 class="mt-3">Keamanan Data</h5>
            <p>Enkripsi data dan autentikasi berlapis untuk melindungi privasi pengguna.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-card">
            <i class="bi bi-phone display-4 text-purple mb-3"></i>
            <h5 class="mt-3">Akses Mobile</h5>
            <p>Desain responsif untuk akses mudah melalui ponsel dan tablet.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- NILAI DASAR PERDAMAIAN -->
  <section id="nilai" class="bg-light" data-aos="fade-up">
    <div class="container">
      <h2 class="text-center mb-5">12 Nilai Dasar Perdamaian</h2>
      <div class="row g-4">
        <div class="col-md-3" data-aos="zoom-in">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/1. Menerima Diri.jpg') }}" class="img-fluid rounded mb-3" alt="Menerima Diri Sendiri">
            <h5>Menerima Diri Sendiri</h5>
            <p>Aku bangga jadi diri sendiri. Mengenal dan mensyukuri diri apa adanya.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/2. Memahami Prasangka.png') }}" class="img-fluid rounded mb-3" alt="Prasangka dan Curiga">
            <h5>Prasangka dan Curiga</h5>
            <p>No curiga, no prasangka. Jangan menilai seseorang dari kelompoknya.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/3. Perbedaan Etnis _ Suku.jpg') }}" class="img-fluid rounded mb-3" alt="Keberagaman Suku">
            <h5>Keberagaman Suku</h5>
            <p>Beda kebudayaan tetap berteman. Belajar dari perbedaan budaya.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/4.Perbedaan Agama.png') }}" class="img-fluid rounded mb-3" alt="Keberagaman Agama">
            <h5>Keberagaman Agama</h5>
            <p>Beda keyakinan nggak usah musuhan. Dialog damai antar agama.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/5.Perbedaan Gender.jpg') }}" class="img-fluid rounded mb-3" alt="Perbedaan Status Gender">
            <h5>Perbedaan Status Gender</h5>
            <p>Laki-laki perempuan sama-sama manusia. Hormati kesetaraan gender.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/6.Perbedaan Status Ekonomi.jpg') }}" class="img-fluid rounded mb-3" alt="Status Ekonomi">
            <h5>Status Ekonomi</h5>
            <p>Kaya nggak sombong, miskin nggak minder. Nilai manusia bukan dari harta.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/7.Perbedaan Kelompok _ Geng.jpg') }}" class="img-fluid rounded mb-3" alt="Nge-Genk">
            <h5>Nge-Genk</h5>
            <p>Kalau gentleman nggak usah nge-gank. Hindari kelompok eksklusif negatif.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/8. Memahami Perbedaan.jpg') }}" class="img-fluid rounded mb-3" alt="Perbedaan">
            <h5>Perbedaan</h5>
            <p>Indahnya perbedaan. Persatuan dalam keberagaman.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/9.Mengatasi Konflik.jpg') }}" class="img-fluid rounded mb-3" alt="Menyelesaikan Konflik">
            <h5>Menyelesaikan Konflik</h5>
            <p>Konflik bikin kamu makin dewasa. Selesaikan dengan damai.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/10.Menolak Kekerasan.jpg') }}" class="img-fluid rounded mb-3" alt="Kekerasan">
            <h5>Kekerasan</h5>
            <p>Pake otak! Jangan maen otot. Tolak kekerasan untuk perdamaian.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/11.Mengakui Kesalahan.jpg') }}" class="img-fluid rounded mb-3" alt="Mengaku Salah">
            <h5>Mengaku Salah</h5>
            <p>Nggak gengsi ngaku salah. Minta maaf untuk rekonsiliasi.</p>
          </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
          <div class="nilai-item text-center">
            <img src="{{ asset('images/12.Memberi Maaf.jpg') }}" class="img-fluid rounded mb-3" alt="Mengampuni dan Memaafkan">
            <h5>Mengampuni dan Memaafkan</h5>
            <p>Nggak pelit memberi maaf. Maafkan untuk jalan menuju perdamaian.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- MAKNA KITA SECTION -->
<section id="makna-kita" class="py-5" data-aos="fade-up">
  <div class="container text-center">
    
    <h2 class="mb-4">
      Makna dari <span style="color:red;">KITA</span>
    </h2>

    <p class="text-muted mb-5 px-md-5">
      <strong>KARAKTERKITA</strong> bukan sekadar nama — ia mengandung filosofi untuk membentuk karakter yang utuh.
      <br>“<strong>KITA</strong>” adalah empat pilar utama pembentuk karakter positif:
    </p>

    <div class="row g-4 justify-content-center">

      <!-- KASIH -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="50">
        <div class="card border-0 shadow-sm p-4 h-100 rounded-4 glass-kita">
          <div class="icon-circle mb-3 bg-danger-subtle text-danger">
            ❤️
          </div>
          <h5 class="fw-bold mb-2">K — Kasih</h5>
          <p class="small text-muted">
            Sikap hati yang penuh kesabaran & kebaikan. Mudah mengampuni & selalu membawa damai.
          </p>
        </div>
      </div>

      <!-- INTEGRITAS -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="150">
        <div class="card border-0 shadow-sm p-4 h-100 rounded-4 glass-kita">
          <div class="icon-circle mb-3 bg-primary-subtle text-primary">
            🔒
          </div>
          <h5 class="fw-bold mb-2">I — Integritas</h5>
          <p class="small text-muted">
            Jujur, bisa dipercaya, dan konsisten antara kata & tindakan. Berperilaku benar meski tidak sedang dilihat.
          </p>
        </div>
      </div>

      <!-- TOLERANSI -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="250">
        <div class="card border-0 shadow-sm p-4 h-100 rounded-4 glass-kita">
          <div class="icon-circle mb-3 bg-success-subtle text-success">
            🤝
          </div>
          <h5 class="fw-bold mb-2">T — Toleransi</h5>
          <p class="small text-muted">
            Menghargai perbedaan pendapat, budaya, keyakinan, dan latar belakang.
          </p>
        </div>
      </div>

      <!-- AMANAH -->
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="350">
        <div class="card border-0 shadow-sm p-4 h-100 rounded-4 glass-kita">
          <div class="icon-circle mb-3 bg-warning-subtle text-warning">
            🛡
          </div>
          <h5 class="fw-bold mb-2">A — Amanah</h5>
          <p class="small text-muted">
            Bertanggung jawab atas kepercayaan & tugas yang diamanahkan.
          </p>
        </div>
      </div>

    </div>

    <div class="mt-5">
      <span class="badge rounded-pill bg-success px-4 py-2 fs-6 animate__animated animate__fadeInUp">
        ✨ Bersama, kita membangun karakter bangsa ✨
      </span>
    </div>

  </div>
</section>
<!-- VISI MISI SECTION -->
<section id="visi-misi" class="py-5 bg-light" data-aos="fade-up">
  <div class="container">

    <h2 class="text-center mb-4 fw-bold">
      🎯 Visi & Misi Rumah Cerdas <span style="color:red;">KITA</span>
    </h2>

    <!-- VISI -->
    <div class="card border-0 shadow-sm glass-kita px-4 py-3 mb-4">
      <h5 class="fw-bold text-success mb-2"><i class="bi bi-stars"></i> VISI</h5>
      <p class="text-muted mb-0">
        Membentuk generasi yang berakhlak mulia, cerdas, berkarakter, amanah, berintegritas, toleransi berbudaya, pemimpin yang beriman,
        pribadi yang berkualitas dan berani tampil beda.
      </p>
    </div>

    <!-- MISI -->
    <div class="card border-0 shadow-sm glass-kita px-4 py-4">
      <h5 class="fw-bold text-success mb-3"><i class="bi bi-bullseye"></i> MISI</h5>
      <ul class="text-muted">
        <li>Menanamkan nilai-nilai kebenaran, kebaikan & kedamaian melalui pelajaran Character Building.</li>
        <li>Menggali potensi peserta didik agar percaya diri, aktif, kreatif, inovatif.</li>
        <li>Mengembangkan perilaku peduli, jujur & disiplin.</li>
        <li>Proses pembelajaran dengan strategi PAIKEM & Active Learning.</li>
        <li>Meningkatkan kualitas pembimbing melalui seminar & pelatihan.</li>
        <li>Menjalin komunikasi harmonis antara pembimbing, orang tua & masyarakat.</li>
        <li>Membangun kemitraan berkelanjutan dengan berbagai organisasi sevisi.</li>
      </ul>
    </div>

  </div>
</section>
<!-- ========== PROGRAM UNGGULAN SECTION ========== -->
<section id="program" class="py-5 bg-white" data-aos="fade-up">
  <div class="container">

    <h2 class="text-center fw-bold mb-5">
      📚 Program Unggulan Rumah Cerdas <span style="color:#e63946;">KITA</span>
    </h2>

    <div class="row g-4">
      @php
        $programs = [
          [
            'icon' => '🔤',
            'color' => 'warning',
            'title' => 'Calistung',
            'desc' => '',
            'content' => '
              <ul class="text-muted mt-3 small text-start mx-auto" style="max-width: 280px;">
                <li><strong>BACA</strong>: Berpikir aktif & memahami makna</li>
                <li><strong>TULIS</strong>: Ekspresi melalui simbol, gambar & kata</li>
                <li><strong>HITUNG</strong>: Berpikir logis, sabar & problem solving</li>
              </ul>'
          ],
          [
            'icon' => '🌱',
            'color' => 'info',
            'title' => 'CERDAS KITA',
            'desc' => '(Cekatan, Empati, Rajin, Disiplin, Aktif, Soleh)',
            'content' => '
              <ul class="text-muted mt-3 small text-start mx-auto" style="max-width: 280px;">
                <li>Cepat tanggap & problem solving</li>
                <li>Peduli sesama</li>
                <li>Belajar konsisten</li>
                <li>Tertib & menghargai waktu</li>
                <li>Aktif, kreatif & percaya diri</li>
                <li>Beriman & berakhlak</li>
              </ul>'
          ],
          [
            'icon' => '🗣️',
            'color' => 'primary',
            'title' => 'Private English',
            'desc' => 'Grammar, vocabulary, speaking & listening berbasis kebutuhan siswa.',
            'content' => '
              <ul class="text-muted mt-3 small text-start mx-auto" style="max-width: 280px;">
                <li>Komunikasi aktif sehari-hari</li>
                <li>Academic writing & comprehension</li>
                <li>Confidence public speaking</li>
              </ul>'
          ],
        ];
      @endphp

      @foreach ($programs as $i => $p)
        <div class="col-12 col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $i * 150 }}">
          <div class="card h-100 border-0 shadow-sm rounded-4 d-flex flex-column align-items-center justify-content-center text-center p-5">
            
            <!-- Icon -->
            <div class="icon-circle d-flex align-items-center justify-content-center mb-3"
                 style="width:70px;height:70px;border-radius:50%;
                        background-color:var(--bs-{{ $p['color'] }}-subtle,#fff3cd);
                        color:var(--bs-{{ $p['color'] }},#f1c40f);
                        font-size:28px;">
              {{ $p['icon'] }}
            </div>

            <!-- Title -->
            <h5 class="fw-bold mb-1">{{ $p['title'] }}</h5>

            <!-- Description (optional) -->
            @if(!empty($p['desc']))
              <p class="text-muted small mb-2" style="max-width: 280px;">{{ $p['desc'] }}</p>
            @endif

            <!-- Content List -->
            <div class="flex-grow-1 d-flex align-items-center justify-content-center w-100">
              {!! $p['content'] !!}
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="text-center mt-5">
      <a href="#kontak" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
        🎓 Daftar Program Sekarang
      </a>
    </div>

  </div>
</section>
<!-- FAQ SECTION -->
<section id="faq" class="py-5 bg-light" data-aos="fade-up">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">
      ❓ Pertanyaan yang Sering Diajukan (FAQ)
    </h2>

    <div class="row justify-content-center">
      <div class="col-lg-10">

        <div class="accordion" id="faqAccordion">

          <!-- FAQ Item 1 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#faqOne" aria-expanded="true" aria-controls="faqOne">
                Bagaimana cara mendaftar di RCK?
              </button>
            </h2>
            <div id="faqOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Orang tua atau wali dapat mendaftarkan anak melalui formulir pendaftaran yang dibuka setiap periode penerimaan siswa baru, baik secara langsung maupun online.
              </div>
            </div>
          </div>

          <!-- FAQ Item 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faqTwo" aria-expanded="false" aria-controls="faqTwo">
                Apa yang diajarkan di RCK?
              </button>
            </h2>
            <div id="faqTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Selain pelajaran akademik seperti Matematika, Bahasa Indonesia, dan Bahasa Inggris, RCK juga memiliki kelas <strong>Character Building</strong> yang berfokus pada <strong>12 Nilai Dasar Perdamaian</strong>.
              </div>
            </div>
          </div>

          <!-- FAQ Item 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faqThree" aria-expanded="false" aria-controls="faqThree">
                Siapa saja yang bisa menjadi siswa RCK?
              </button>
            </h2>
            <div id="faqThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Anak-anak usia <strong>4–12 tahun</strong> (TK hingga SD kelas 6) dapat menjadi siswa di Rumah Cerdas KITA.
              </div>
            </div>
          </div>

          <!-- FAQ Item 4 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faqFour" aria-expanded="false" aria-controls="faqFour">
                Bagaimana cara menjadi relawan di RCK?
              </button>
            </h2>
            <div id="faqFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Siapa pun yang memiliki kepedulian terhadap pendidikan dan karakter anak dapat mendaftar sebagai relawan melalui email:
                <a href="mailto:rumahcerdaskita179@gmail.com" class="text-success fw-semibold text-decoration-none">
                  rumahcerdaskita179@gmail.com
                </a>.
              </div>
            </div>
          </div>

          <!-- FAQ Item 5 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faqFive" aria-expanded="false" aria-controls="faqFive">
                Apa tujuan utama program Character Building di RCK?
              </button>
            </h2>
            <div id="faqFive" class="accordion-collapse collapse" aria-labelledby="faqHeadingFive"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Untuk menanamkan nilai-nilai <strong>perdamaian, empati, tanggung jawab,</strong> dan <strong>menghargai perbedaan</strong> sejak dini agar anak tumbuh menjadi pribadi yang baik dan percaya diri.
              </div>
            </div>
          </div>

          <!-- FAQ Item 6 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeadingSix">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#faqSix" aria-expanded="false" aria-controls="faqSix">
                Apakah RCK menerima relawan atau donatur?
              </button>
            </h2>
            <div id="faqSix" class="accordion-collapse collapse" aria-labelledby="faqHeadingSix"
              data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Ya. Kami membuka kesempatan bagi siapa pun yang ingin menjadi <strong>relawan pengajar</strong> atau mendukung kegiatan pendidikan melalui <strong>donasi</strong>.
                <br>Informasi lebih lanjut hubungi kami melalui
                <a href="https://wa.me/6281370434017" target="_blank" class="text-success text-decoration-none fw-semibold">
                  WhatsApp resmi RCK
                </a>.
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </div>
</section>


<!-- GALERI KEGIATAN -->
<section id="galeri" class="py-5" style="background:#f2f5f7;">
  <div class="container">

    <!-- Title -->
    <div class="text-center mb-5" data-aos="fade-up">
      <h2 class="fw-bold text-dark">
        🎥 Galeri Video Rumah Cerdas <span style="color:#ff3b3b;">KITA</span>
      </h2>
      <p class="text-muted">Kumpulan momen berharga kegiatan belajar, kebersamaan, dan acara seru kami.</p>
    </div>

    <!-- Video Gallery -->
    <div class="row justify-content-center g-4">
      @php
        $videos = [
          [
            'src' => 'https://www.youtube.com/embed/wXFFq2rew4c',
            'title' => 'Permainan Lama, Persahabatan Baru | HUT RI ke-80 di Lampions Park'
          ],
          [
            'src' => 'https://www.youtube.com/embed/LDiC1WVKeKU',
            'title' => 'RCK\'s Family Gathering 2025 | Faith, Hope and Love'
          ],
          [
            'src' => 'https://www.youtube.com/embed/5nmDryKq01g',
            'title' => 'Pertemuan Orang Tua & Pembagian Laporan Hasil Belajar | 25 Juni 2025'
          ],
          [
            'src' => 'https://www.youtube.com/embed/_Q1xc_54EgY',
            'title' => 'Farewell Kelas 6 Rumah Cerdas KITA di Pandiga Cimahi! | Outbound & Berenang Seru'
          ],
        ];
      @endphp

      @foreach($videos as $video)
      <div class="col-lg-3 col-md-6 col-sm-12 d-flex justify-content-center" data-aos="zoom-in">
        <div class="video-card shadow-lg rounded-4 overflow-hidden bg-white w-100">
          <div class="ratio ratio-16x9">
            <iframe 
              src="{{ $video['src'] }}" 
              title="{{ $video['title'] }}" 
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
              referrerpolicy="strict-origin-when-cross-origin" 
              allowfullscreen>
            </iframe>
          </div>
          <div class="p-3 text-center">
            <h6 class="fw-semibold text-dark mb-0" style="font-size:0.9rem;">
              {{ $video['title'] }}
            </h6>
          </div>
        </div>
      </div>
      @endforeach
    </div>

  </div>
</section>

<!-- Optional Styling -->
<style>
  .video-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .video-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  }
</style>


<!-- TIM PENGAJAR -->
<section id="tim" class="py-5 bg-white" data-aos="fade-up">
  <div class="container text-center">
    <h2 class="mb-4">Tim Pengajar Rumah Cerdas <span style="color:red;">KITA</span></h2>
    <p class="text-muted mb-5">Bersama pendidik hebat yang profesional & penuh dedikasi</p>

    <div id="teamCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- SLIDE 1 -->
        <div class="carousel-item active">
          <div class="row justify-content-center g-4">
            
            @php
              $teachers = [
                ['img' => 'images/teachers/Anggun Puji Nurani.png', 'name' => 'Anggun Puji Nurani', 'role' => 'Guru SD Kelas 5 & 6'],
                ['img' => 'images/teachers/Dest Ester Mbau.jpeg', 'name' => 'Desy Ester Mbau', 'role' => 'Pimpinan Rumah Cerdas KITA'],
                ['img' => 'images/teachers/Ervina Khoerunisa.jpeg', 'name' => 'Ervina Khoerunisa', 'role' => 'Guru SD Kelas 1'],
              ];
            @endphp

            @foreach($teachers as $t)
            <div class="col-md-4">
              <div class="teacher-card glass-card p-4 shadow-lg">
                <img src="{{ asset($t['img']) }}" class="teacher-img mb-3" alt="{{ $t['name'] }}">
                <h5 class="fw-bold">{{ $t['name'] }}</h5>
                <span class="text-muted">{{ $t['role'] }}</span>
              </div>
            </div>
            @endforeach

          </div>
        </div>

        <!-- SLIDE 2 -->
        <div class="carousel-item">
          <div class="row justify-content-center g-4">

            @php
              $teachers2 = [
                ['img' => 'images/teachers/Fitri Aryanti.jpeg', 'name' => 'Fitri Aryanti', 'role' => 'Guru TK'],
                ['img' => 'images/teachers/Irmawati.jpg', 'name' => 'Irmawati', 'role' => 'Guru TK'],
                ['img' => 'images/teachers/Lilis Risma.png', 'name' => 'Lilis Risma', 'role' => 'Guru SD Kelas 2'],
              ];
            @endphp

            @foreach($teachers2 as $t)
            <div class="col-md-4">
              <div class="teacher-card glass-card p-4 shadow-lg">
                <img src="{{ asset($t['img']) }}" class="teacher-img mb-3" alt="{{ $t['name'] }}">
                <h5 class="fw-bold">{{ $t['name'] }}</h5>
                <span class="text-muted">{{ $t['role'] }}</span>
              </div>
            </div>
            @endforeach

          </div>
        </div>

        <!-- SLIDE 3 -->
        <div class="carousel-item">
          <div class="row justify-content-center g-4">
            
            @php
              $teachers3 = [
                ['img' => 'images/teachers/Maria M.B Kulla.jpg', 'name' => 'Maria M.B Kulla', 'role' => 'Guru SD'],
                ['img' => 'images/teachers/Rina Siti Mariana.png', 'name' => 'Rina Siti Mariana', 'role' => 'Guru SD Kelas 3 & 4'],
              ];
            @endphp

            @foreach($teachers3 as $t)
            <div class="col-md-4">
              <div class="teacher-card glass-card p-4 shadow-lg">
                <img src="{{ asset($t['img']) }}" class="teacher-img mb-3" alt="{{ $t['name'] }}">
                <h5 class="fw-bold">{{ $t['name'] }}</h5>
                <span class="text-muted">{{ $t['role'] }}</span>
              </div>
            </div>
            @endforeach

          </div>
        </div>

      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>

    </div>
  </div>
</section>
  <!-- TESTIMONI -->
  <section id="testimoni" data-aos="fade-up">
    <div class="container text-center">
      <h2 class="mb-5">Apa Kata Mereka?</h2>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-right">
          <div class="testimonial-card">
            <img src="{{ asset('images/ibuhana.jpg') }}" alt="User 1">
            <p>"Sebagai orang tua yang sibuk bekerja, saya merasa terbantu dengan sistem KARAKITA. Saya bisa memantau karakter anak tanpa harus datang ke sekolah setiap minggu. Laporan dari guru langsung muncul di website, dan saya bisa isi penilaian dari rumah. Jadi tetap terlibat walau waktu saya terbatas.
"</p>
            <h6>Ibu Hana, Orang Tua Siswa Kelas 3 SD</h6>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="testimonial-card">
            <img src="{{ asset('images/ibukeyra.jpg') }}" alt="User 2">
            <p>"Cucu saya ikut bimbel Rumah Cerdas KITA dan dinilai lewat sistem KARAKITA. Dulu dia agak tertutup dan sulit bergaul, tapi sekarang lebih percaya diri. Saya rasa kombinasi pembelajaran akademik dan karakter seperti ini yang paling dibutuhkan anak-anak sekarang
"</p>
            <h6>Ibu Keyra, Orang Tua Siswa Kelas 6 SD</h6>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
          <div class="testimonial-card">
            <img src="{{ asset('images/tania.jpg') }}" alt="User 3">
            <p>"KARAKITA shows that education is not only about knowledge, but also about kindness, empathy, and peace. I truly admire this program and the values it builds in children."</p>
            <h6>Tania Poppek – Germany</h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- POSTER PENDAFTARAN -->
<section id="pendaftaran" class="py-5" data-aos="fade-up">
  <div class="container">
    <div class="row align-items-center g-5">
      
      <!-- Kolom Kiri: Konten Ajakan -->
      <div class="col-lg-6 text-white" data-aos="fade-right">
        <h2 class="fw-bold mb-3">📢 Penerimaan Peserta Didik Baru</h2>
        <p class="lead mb-4">
          Bergabunglah bersama <strong>Rumah Cerdas KITA</strong> — tempat di mana anak tidak hanya cerdas secara akademik, 
          tapi juga tumbuh menjadi pribadi yang berkarakter, mandiri, dan berakhlak baik.  
        </p>
        <ul class="mb-4">
          <li>✅ Kurikulum berbasis karakter & teknologi</li>
          <li>✅ Program bimbingan personal untuk setiap anak</li>
          <li>✅ Lingkungan belajar yang menyenangkan dan aman</li>
        </ul>
        <a href="#kontak" class="btn btn-warning fw-bold rounded-pill px-4 py-2 shadow-lg">
          ✍️ Daftar Sekarang
        </a>
      </div>

      <!-- Kolom Kanan: Poster -->
      <div class="col-lg-6 text-center" data-aos="fade-left">
        <div class="poster-card shadow-lg rounded-4 overflow-hidden mx-auto">
          <img src="{{ asset('images/psb.jpeg') }}" 
               alt="Poster PPDB RCK"
               class="poster-img">
        </div>
      </div>

    </div>
  </div>
</section>


  <!-- KONTAK -->
  <section id="kontak" data-aos="fade-up">
    <div class="container">
      <h2 class="text-center mb-5 text-white">Hubungi Kami</h2>
      <div class="row g-4 align-items-stretch">
        <div class="col-md-5" data-aos="fade-right">
          <div class="contact-info h-100 p-4 rounded">
            <h5><i class="bi bi-building me-2"></i> Rumah Cerdas KITA</h5>
            <p>Pusat Pengembangan Karakter Siswa Indonesia</p>
            <p><i class="bi bi-envelope me-2"></i> rumahcerdaskita179@gmail.com</p>
            <p><i class="bi bi-whatsapp me-2"></i> 0813-7043-4017</p>
            <p><i class="bi bi-geo-alt me-2"></i> Jl. Terusan Pasirkoja, Jamika, Kec. Bojongloa Kaler, Kota Bandung, Jawa Barat 40242</p>
            <div class="social-media mt-3">
              <p><i class="bi bi-instagram me-2"></i> <a href="https://www.instagram.com/bimbel_rck/" target="_blank">Instagram: @bimbel_rck</a></p>
              <p><i class="bi bi-youtube me-2"></i> <a href="https://www.youtube.com/@RumahCerdasKITA" target="_blank">YouTube: Rumah Cerdas KITA</a></p>
            </div>
            <a href="mailto:info@rumahcerdaskita.id" class="btn btn-custom mt-3"><i class="bi bi-send me-2"></i> Kirim Pesan</a>
          </div>
        </div>
        <div class="col-md-7" data-aos="fade-left" data-aos-delay="100">
          <div class="map-container">
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.7043990019224!2d107.58925339999999!3d-6.925894399999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e61c56583b71%3A0xc8fedb60a238a923!2sRumah%20Cerdas%20Kita!5e0!3m2!1sid!2sid!4v1760949974323!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <p>© 2025 KARAKITA - Rumah Cerdas KITA. Semua Hak Dilindungi.</p>
  </footer>

  <!-- WA CHAT -->
  <div class="wa-chat">
    <a href="https://wa.me/6281370434017?text=Halo%20Rumah%20Cerdas%20KITA!%20Saya%20ingin%20bertanya%20tentang%20program%20KARAKTERKITA." target="_blank" title="Chat WhatsApp">
      <i class="bi bi-whatsapp"></i>
    </a>
  </div>

  <!-- BACK TO TOP -->
  <a href="#" class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></a>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({ duration: 1000, once: true });

    // Back to Top
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        backToTop.classList.add('show');
      } else {
        backToTop.classList.remove('show');
      }
    });
  </script>
  <script>
var swiper = new Swiper(".mySwiper", {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  breakpoints: {
    768: { slidesPerView: 2 },
    992: { slidesPerView: 3 }
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  }
});
</script>

  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
</body>
</html>