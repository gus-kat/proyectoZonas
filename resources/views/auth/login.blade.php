<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Ingrese su Correo Electonico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordar') }}</span>
            </label>
        </div>
   
    <div class="mt-6 flex justify-center space-x-4">
        <a href="{{ route('register') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            ¿No tienes una Cuenta?
        </a>
        <x-primary-button class="bg-green-600 hover:bg-green-700 focus:ring-green-500">
            {{ __('Ingresar') }}
        </x-primary-button>
    </div>



    @if(session('mensaje'))
    <script>
        Swal.fire({
            title: "Confirmación",
            text: "{{ session('mensaje') }}",
            icon: "success"
        });
    </script>
@endif

</x-guest-layout>

