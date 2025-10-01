<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />
    
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- Logo -->
            <div class="login-logo text-center mb-4">
                <img src="/images/logo.png" alt="UPG MIS Logo" class="img-fluid mb-2" style="max-width: 140px;">
                <h1 class="h5 font-weight-bold">UPG MIS</h1>
            </div>
            
            <!-- Login Card -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    
                    <!-- Success Message -->
                    <div v-if="status" class="alert alert-success mb-3">
                        {{ status }}
                    </div>
                    
                    <form @submit.prevent="submit">
                        <!-- Email -->
                        <div class="input-group mb-3">
                            <input 
                                id="email"
                                type="email"
                                class="form-control"
                                placeholder="Email"
                                v-model="form.email"
                                required
                                autofocus
                                autocomplete="username"
                                :class="{ 'is-invalid': form.errors.email }"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            <div v-if="form.errors.email" class="invalid-feedback">
                                {{ form.errors.email }}
                            </div>
                        </div>
                        
                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input 
                                id="password"
                                type="password"
                                class="form-control"
                                placeholder="Password"
                                v-model="form.password"
                                required
                                autocomplete="current-password"
                                :class="{ 'is-invalid': form.errors.password }"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div v-if="form.errors.password" class="invalid-feedback">
                                {{ form.errors.password }}
                            </div>
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="row mb-3">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember" v-model="form.remember">
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block"
                                    :disabled="form.processing">
                                    <span v-if="form.processing">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <span v-else>Sign In</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Forgot Password -->
                    <p class="mb-1" v-if="canResetPassword">
                        <Link :href="route('password.request')" class="text-center">
                            Forgot your password?
                        </Link>
                    </p>
                    
                    <!-- Register Link -->
                    <p class="mb-0">
                        <Link :href="route('register')" class="text-center">
                            Register a new account
                        </Link>
                    </p>
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
    background: #f4f6f9;
}

.login-box {
    width: 360px;
    margin: 0 auto;
}

.login-logo {
    margin-bottom: 1.5rem;
}

.login-card-body {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.login-box-msg {
    color: #666;
    margin-bottom: 1.5rem;
    text-align: center;
}

.icheck-primary input:checked ~ label::before {
    background-color: #2563eb !important;
    border-color: #2563eb !important;
}

/* Ensure the page fills the entire viewport */
html, body {
    height: 100%;
    margin: 0;
}
</style>
