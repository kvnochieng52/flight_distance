<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Confirm Password" />
    
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- Logo -->
            <div class="login-logo text-center mb-4">
                <img src="/images/logo.png" alt="UPG MIS Logo" class="img-fluid mb-2" style="max-width: 140px;">
                <h1 class="h5 font-weight-bold">UPG MIS</h1>
            </div>
            
            <!-- Confirm Password Card -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg font-weight-bold">Confirm Password</p>
                    
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-shield-alt mr-2"></i>
                        This is a secure area of the application. Please confirm your password before continuing.
                    </div>
                    
                    <form @submit.prevent="submit">
                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input 
                                id="password"
                                type="password" 
                                class="form-control" 
                                placeholder="Password" 
                                v-model="form.password"
                                required
                                autofocus
                                autocomplete="current-password"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.password" class="text-danger text-sm mb-3">{{ form.errors.password }}</div>
                        
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block"
                                    :disabled="form.processing">
                                    <span v-if="form.processing">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Processing...
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-check-circle mr-1"></i> Confirm Password
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Back link -->
                    <div class="text-center mt-3">
                        <Link :href="route('dashboard')" class="text-center">
                            <i class="fas fa-arrow-left mr-1"></i> Back to dashboard
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* AdminLTE Login Page Styles */
.login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
}

.login-logo {
    margin-bottom: 20px;
}

.login-card-body {
    border-radius: 8px;
    box-shadow: 0 5px 20px rgba(0,0,0,.1);
    padding: 30px;
}

.login-box-msg {
    font-size: 1.2rem;
    margin-bottom: 5px;
}

.input-group-text {
    background-color: transparent;
}
</style>
