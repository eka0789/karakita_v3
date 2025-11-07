<x-guest-layout>
  <style>
    body {
      background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
      font-family: 'Poppins', sans-serif;
    }
    .login-container {
      display: flex;
      flex-wrap: wrap;
      min-height: 100vh;
      align-items: center;
      justify-content: center;
      padding: 2rem;
    }
    .login-left {
      flex: 1 1 400px;
      max-width: 480px;
      background: white;
      border-radius: 1rem;
      padding: 2.5rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.8s ease;
    }
    .login-right {
      flex: 1 1 400px;
      text-align: center;
      padding: 2rem;
    }
    .login-right img {
      width: 100%;
      max-width: 400px;
      animation: float 3s ease-in-out infinite;
    }
    .brand-title {
      font-weight: 700;
      font-size: 2rem;
      color: #2E7D32;
    }
    .tagline {
      color: #4B5563;
      font-size: 1rem;
      margin-top: 0.5rem;
      margin-bottom: 2rem;
    }
    .btn-login {
      background-color: #59AC77;
      border: none;
      color: white;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      transition: background 0.3s;
      font-weight: 600;
    }
    .btn-login:hover {
      background-color: #4b9164;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>

  <div class="login-container">
    <!-- Left Panel -->
    <div class="login-left">
      <div class="text-center mb-4">
        <h1 class="brand-title">🌱 Karakter<span style="color:#59AC77">Kita</span></h1>
        <p class="tagline">Belajar membangun karakter dengan semangat yang positif 🌼</p>
      </div>

      <!-- Session Status -->
      <x-auth-session-status class="mb-4" :status="session('status')" />

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3">
          <x-input-label for="email" :value="__('Email')" />
          <x-text-input id="email" class="block mt-1 w-full border-gray-300 rounded-md" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
          <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
          <x-input-label for="password" :value="__('Password')" />
          <x-text-input id="password" class="block mt-1 w-full border-gray-300 rounded-md"
                        type="password" name="password" required autocomplete="current-password" />
          <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4 mb-4">
          <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
            <span class="ms-2 text-sm text-gray-600">{{ __('Ingat saya') }}</span>
          </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
          @if (Route::has('password.request'))
            <a class="text-sm text-gray-500 hover:text-green-700 transition" href="{{ route('password.request') }}">
              {{ __('Lupa kata sandi?') }}
            </a>
          @endif

          <button type="submit" class="btn-login">
            {{ __('Masuk') }}
          </button>
        </div>
      </form>
    </div>

    <!-- Right Panel -->
    <div class="login-right">
      <img src="{{ asset('images/illustration.png') }}" alt="Ilustrasi KarakterKita" />
      <p class="text-gray-600 mt-3">Setiap hari adalah kesempatan untuk tumbuh 🌻</p>
    </div>
  </div>
</x-guest-layout>
