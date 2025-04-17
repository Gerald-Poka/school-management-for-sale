<?php $__env->startSection('title'); ?>
<?php echo app('translator')->get('translation.signin'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Modern auth-page wrapper -->
    <div class="auth-page-wrapper py-5 d-flex justify-content-center align-items-center min-vh-100" 
         style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);">
        <div class="bg-overlay" style="opacity: 0.6;"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden position-relative">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card overflow-hidden border-0 shadow-lg" 
                             style="border-radius: 15px; backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.9);">
                            <div class="row g-0">
                                <div class="col-lg-6 d-none d-lg-block position-relative" 
                                     style="background: url('<?php echo e(URL::asset('school/student1.png')); ?>') center/cover no-repeat;">
                                    <!-- Overlay to ensure text readability -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100" 
                                         style="background: linear-gradient(135deg, rgba(14, 165, 233, 0.85) 0%, rgba(30, 58, 138, 0.85) 100%);"></div>
                                    
                                    <div class="p-lg-5 p-4 h-100 d-flex flex-column position-relative">
                                        <div class="mb-4 text-center">
                                            <a href="index" class="d-block">
                                                <img src="<?php echo e(URL::asset('school/logo.png')); ?>" alt="" height="88" class="mx-auto">
                                            </a>
                                        </div>
                                        <div class="my-5 text-white text-center">
                                            <h2 class="fw-bold mb-3">School Management System</h2>
                                            <p class="fs-16 opacity-75">Access your dashboard to manage all school activities efficiently</p>
                                        </div>
                                        <div class="mt-auto">
                                            <div class="mb-3 text-center">
                                                <i class="ri-double-quotes-l display-4 text-white opacity-75"></i>
                                            </div>

                                            <div id="qoutescarouselIndicators" class="carousel slide"
                                                data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                        data-bs-slide-to="0" class="active" aria-current="true"
                                                        aria-label="Slide 1"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                        data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                    <button type="button" data-bs-target="#qoutescarouselIndicators"
                                                        data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                </div>
                                                <div class="carousel-inner text-center text-white pb-4">
                                                    <div class="carousel-item active">
                                                        <p class="fs-15 fst-italic">" Education is the passport to the future, for tomorrow belongs to those who prepare for it today. "</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">" Our school management system helps teachers focus on what matters most - educating our future leaders. "</p>
                                                    </div>
                                                    <div class="carousel-item">
                                                        <p class="fs-15 fst-italic">" Streamlined administration means more time for quality education and student development. "</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end carousel -->
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div class="text-center mt-2 mb-4 d-block d-lg-none">
                                            <img src="<?php echo e(URL::asset('school/logo.png')); ?>" alt="" height="72">
                                        </div>
                                        <div class="mb-4">
                                            <h4 class="text-primary fw-bold mb-2">Welcome Back!</h4>
                                            <p class="text-muted">Sign in to continue to your dashboard.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="<?php echo e(route('login')); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email Address</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="ri-mail-line text-muted"></i>
                                                        </span>
                                                        <input type="email" class="form-control border-start-0 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                               name="email" id="email" value="<?php echo e(old('email')); ?>"
                                                               placeholder="Enter email" required>
                                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="<?php echo e(route('password.update')); ?>" class="text-muted fs-13">Forgot password?</a>
                                                    </div>
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="input-group auth-pass-inputgroup">
                                                        <span class="input-group-text bg-light border-end-0">
                                                            <i class="ri-lock-2-line text-muted"></i>
                                                        </span>
                                                        <input type="password" class="form-control border-start-0 pe-5 password-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                               name="password" placeholder="Enter password" id="password-input" required>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                                type="button" id="password-addon" style="z-index: 10; padding-top: 12px;">
                                                            <i class="ri-eye-fill align-middle"></i>
                                                        </button>
                                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>

                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="remember" 
                                                           id="auth-remember-check" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-primary w-100 py-2" type="submit">
                                                        <i class="ri-login-circle-line me-1"></i> Sign In
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        
                                        <div class="mt-5 text-center">
                                            <p class="mb-0 text-muted">Don't have an account? 
                                                <a href="https://wa.me/255754316484" target="_blank" class="fw-semibold text-primary">
                                                    <i class="ri-whatsapp-line align-middle"></i> Contact Administrator
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer start-0 position-absolute bottom-0 w-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-white-50">&copy; <script>document.write(new Date().getFullYear())</script> 
                                School <i class="mdi mdi-heart text-danger"></i> by Gerald Ndyamukama
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('build/js/pages/password-addon.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\modern\resources\views/auth/login.blade.php ENDPATH**/ ?>