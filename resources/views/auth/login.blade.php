<x-guest-layout>

    <style>
        body {
            background: #f1f3f5;
        }

        .login-box {
            max-width: 420px;
            background: white;
            padding: 35px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.08);
            animation: fadeIn .4s ease-in-out;
        }

        .login-title {
            font-size: 26px;
            font-weight: bold;
            color: #0d6efd;
            text-align: center;
            margin-bottom: 10px;
        }

        .auth-link {
            color: #0d6efd;
            text-decoration: none;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    <div class="login-box">

        <h2 class="login-title">Iniciar Sesión</h2>

        <!-- Mensajes de estado -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Formulario -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mt-3">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" type="email" name="email" class="block mt-1 w-full"
                              :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="'Contraseña'" />
                <x-text-input id="password" type="password" name="password"
                              class="block mt-1 w-full" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Recordarme -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm"
                           name="remember">
                    <span class="ml-2 text-sm text-gray-600">Recordarme</span>
                </label>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-4">

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-link text-sm">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif

                <x-primary-button>Ingresar</x-primary-button>
            </div>

        </form>

        <p class="mt-4 text-center text-sm">
            ¿No tienes cuenta?  
            <a href="{{ route('register') }}" class="auth-link fw-bold">Registrarse</a>
        </p>

    </div>

</x-guest-layout>
