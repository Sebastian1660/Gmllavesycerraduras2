<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="{{ asset('imagenes/imagenes/LOGOO.JPG ') }}" alt="GM Llaves y Cerraduras" style="width: 80px; height: 80px; margin: 0 auto 15px;">
                <h2>Iniciar Sesión</h2>
                <p style="color: #666; font-size: 14px; margin-top: 5px;">GM Llaves y Cerraduras</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="form-input"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="form-check">
                    <label for="remember_me" class="remember-label">
                        <input id="remember_me" type="checkbox" name="remember">
                        <span>{{ __('Recordarme') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary">
                    Iniciar Sesión
                </button>

                <!-- Links -->
                <div class="auth-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="link-secondary">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <!-- Register Link -->
                <div class="auth-footer">
                    <p>¿No tienes una cuenta? 
                        <a href="{{ route('register') }}" class="link-primary">Regístrate aquí</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>