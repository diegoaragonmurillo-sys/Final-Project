<x-guest-layout>

    <style>
        body {
            background: #f1f3f5;
        }

        .register-box {
            max-width: 450px;
            background: white;
            padding: 35px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0,0,0,0.08);
            animation: fadeIn .4s ease-in-out;
        }

        .register-title {
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

    <div class="register-box">

        <h2 class="register-title"> Crear Cuenta</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- Nombre --}}
            <div>
                <x-input-label for="name" :value="'Nombre completo'" />
                <x-text-input id="name" type="text" name="name" 
                              class="block mt-1 w-full"
                              :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mt-4">
                <x-input-label for="email" :value="'Correo electrónico'" />
                <x-text-input id="email" type="email" name="email"
                              class="block mt-1 w-full" 
                              :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mt-4">
                <x-input-label for="password" :value="'Contraseña'" />
                <x-text-input id="password" type="password" 
                              name="password" class="block mt-1 w-full" 
                              required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirm Password --}}
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="'Confirmar contraseña'" />
                <x-text-input id="password_confirmation" type="password"
                              name="password_confirmation"
                              class="block mt-1 w-full" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- Botón --}}
            <div class="flex items-center justify-between mt-4">

                <a href="{{ route('login') }}" class="auth-link text-sm">
                    ¿Ya tienes una cuenta?
                </a>

                <x-primary-button class="ms-4">
                    Registrar
                </x-primary-button>

            </div>
        </form>

        <p class="mt-4 text-center text-sm text-muted">
             Tus datos están seguros con nosotros.
        </p>

    </div>

</x-guest-layout>
