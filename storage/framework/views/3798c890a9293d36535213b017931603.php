<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        
        <h4 class="text-primary my-4">¡Iniciar Sesión!</h4>
        
        <!-- Email Address -->
        <div class="form-group">
            <input type="email" 
                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="email" 
                   name="email" 
                   value="<?php echo e(old('email')); ?>" 
                   placeholder="Correo Electrónico" 
                   required 
                   autofocus 
                   autocomplete="username">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Password -->
        <div class="form-group">
            <input type="password" 
                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   id="password" 
                   name="password" 
                   placeholder="Contraseña" 
                   required 
                   autocomplete="current-password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="invalid-feedback">
                    <?php echo e($message); ?>

                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                    <?php if(Route::has('password.request')): ?>
                        <a id="forgot-psw" href="<?php echo e(route('password.request')); ?>" class="font-14">¿Olvidaste tu contraseña?</a>
                    <?php endif; ?>
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
    
    <?php if(Route::has('register')): ?>
        <p class="mb-0 mt-3">¿No tienes una cuenta? <a href="<?php echo e(route('register')); ?>">Regístrate</a></p>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH D:\proyectos_php\sichera_2025\resources\views/auth/login.blade.php ENDPATH**/ ?>