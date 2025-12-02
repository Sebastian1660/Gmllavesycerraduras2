<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="{{ asset('imagenes/imagenes/LOGOO.JPG ') }}" alt="GM Llaves y Cerraduras" style="width: 80px; height: 80px; margin: 0 auto 15px;">
                <h2>Crear Cuenta</h2>
                <p style="color: #666; font-size: 14px; margin-top: 5px;">GM Llaves y Cerraduras</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div class="form-group">
                    <x-input-label for="name" :value="__('Nombre')" />
                    <x-text-input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Correo Electrónico -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Contraseña -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="form-input"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                    <x-text-input id="password_confirmation" class="form-input"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Botón de Envío -->
                <button type="submit" class="btn-primary">
                    Registrarse
                </button>

                <!-- Enlace de Inicio de Sesión -->
                <div class="auth-footer">
                    <p>¿Ya tienes una cuenta? 
                        <a href="{{ route('login') }}" class="link-primary">Inicia sesión aquí</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>