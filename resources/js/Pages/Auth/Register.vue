<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />
    
    <div class="hold-transition register-page">
        <div class="register-box">
            <!-- Logo -->
            <div class="register-logo text-center mb-4">
                <img src="/images/logo.png" alt="UPG MIS Logo" class="img-fluid mb-2" style="max-width: 140px;">
                <h1 class="h5 font-weight-bold">UPG MIS</h1>
            </div>
            
            <!-- Register Card -->
            <div class="card">
                <div class="card-body register-card-body">
                    <p class="register-box-msg">Register a new account</p>
                    
                    <form @submit.prevent="submit">
                        <!-- Name -->
                        <div class="input-group mb-3">
                            <input 
                                id="name"
                                type="text"
                                class="form-control"
                                placeholder="Full name"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                :class="{ 'is-invalid': form.errors.name }"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            <div v-if="form.errors.name" class="invalid-feedback">
                                {{ form.errors.name }}
                            </div>
                        </div>
                        
                        <!-- Email -->
                        <div class="input-group mb-3">
                            <input 
                                id="email"
                                type="email"
                                class="form-control"
                                placeholder="Email"
                                v-model="form.email"
                                required
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
                                autocomplete="new-password"
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
                        
                        <!-- Confirm Password -->
                        <div class="input-group mb-3">
                            <input 
                                id="password_confirmation"
                                type="password"
                                class="form-control"
                                placeholder="Confirm password"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                :class="{ 'is-invalid': form.errors.password_confirmation }"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            <div v-if="form.errors.password_confirmation" class="invalid-feedback">
                                {{ form.errors.password_confirmation }}
                            </div>
                        </div>
                        
                        <!-- Register Button -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block"
                                    :disabled="form.processing">
                                    <span v-if="form.processing">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <span v-else>Register</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Login Link -->
                    <div class="text-center mt-3">
                        <Link :href="route('login')" class="text-center">
                            Already have an account? Sign in
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* AdminLTE Register Page Styles */
.register-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f4f6f9;
}

.register-box {
    width: 400px;
    margin: 0 auto;
}

.register-logo {
    margin-bottom: 1.5rem;
}

.register-card-body {
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.register-box-msg {
    color: #666;
    margin-bottom: 1.5rem;
    text-align: center;
}

/* Ensure the page fills the entire viewport */
html, body {
    height: 100%;
    margin: 0;
}
</style>
