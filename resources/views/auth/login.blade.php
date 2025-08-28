<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        
        <h4 class="text-primary my-4">¡Iniciar Sesión!</h4>
        
        <!-- Email Address -->
        <div class="form-group">
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Correo Electrónico" 
                   required 
                   autofocus 
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Password -->
        <div class="form-group">
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   placeholder="Contraseña" 
                   required 
                   autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Remember Me & Forgot Password -->
        <div class="form-row mb-3">
            <div class="col-sm-6">
                <div class="custom-control custom-checkbox text-left">
                    <input type="checkbox" class="custom-control-input" id="remember_me" name="remember">
                    <label class="custom-control-label font-14" for="remember_me">Recordarme</label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="forgot-psw">
                    @if (Route::has('password.request'))
                        <a id="forgot-psw" href="{{ route('password.request') }}" class="font-14">¿Olvidaste tu contraseña?</a>
                    @endif
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-success btn-lg btn-block font-18">Iniciar Sesión</button>
    </form>
    
    <div class="login-or">
        <h6 class="text-muted">O</h6>
    </div>
    
    <div class="social-login text-center">
        <button type="button" class="btn btn-primary rounded-circle font-18"><i class="ri-facebook-line"></i></button>
        <button type="button" class="btn btn-danger rounded-circle font-18 ml-2"><i class="ri-google-line"></i></button>
    </div>
    
    {{-- Registro deshabilitado para usuarios externos --}}
</x-guest-layout>
