<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <h4 class="text-primary my-4">¡Crear Cuenta!</h4>
        
        <!-- Name -->
        <div class="form-group">
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}" 
                   placeholder="Nombre Completo" 
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Email Address -->
        <div class="form-group">
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}" 
                   placeholder="Correo Electrónico" 
                   required 
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
                   autocomplete="new-password">
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <!-- Confirm Password -->
        <div class="form-group">
            <input type="password" 
                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   placeholder="Confirmar Contraseña" 
                   required 
                   autocomplete="new-password">
            @error('password_confirmation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success btn-lg btn-block font-18">Registrarse</button>
    </form>
    
    <div class="login-or">
        <h6 class="text-muted">O</h6>
    </div>
    
    <div class="social-login text-center">
        <button type="button" class="btn btn-primary rounded-circle font-18"><i class="ri-facebook-line"></i></button>
        <button type="button" class="btn btn-danger rounded-circle font-18 ml-2"><i class="ri-google-line"></i></button>
    </div>
    
    <p class="mb-0 mt-3">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a></p>
</x-guest-layout>
