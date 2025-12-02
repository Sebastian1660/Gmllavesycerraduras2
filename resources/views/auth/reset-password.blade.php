<x-guest-layout>
    <div class="auth-container">
        <div class="auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <img src="{{ asset('imagenes/imagenes/LOGOO.jpg') }}" alt="GM Llaves y Cerraduras" style="width: 80px; height: 80px; margin: 0 auto 15px; object-fit: contain;">
                <h2>Restablecer Contraseña</h2>
                <p style="color: #666; font-size: 14px; margin-top: 5px;">GM Llaves y Cerraduras</p>
            </div>

            <!-- Mensaje informativo -->
            <div style="background: #f0f7ff; border-left: 4px solid #1e5bb8; padding: 15px; border-radius: 5px; margin-bottom: 25px;">
                <p style="margin: 0; color: #333; font-size: 14px; line-height: 1.5;">
                    Ingresa tu nueva contraseña para restablecer el acceso a tu cuenta.
                </p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div class="form-group">
                    <x-input-label for="email" :value="__('Correo Electrónico')" />
                    <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="form-group">
                    <x-input-label for="password" :value="__('Nueva Contraseña')" />
                    <x-text-input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <x-input-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                    <x-text-input id="password_confirmation" class="form-input"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary">
                    Restablecer Contraseña
                </button>

                <!-- Volver al Login -->
                <div class="auth-footer">
                    <p>¿Recordaste tu contraseña? 
                        <a href="{{ route('login') }}" class="link-primary">Volver al inicio de sesión</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>