<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Reset Password" />
    
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- Logo -->
            <div class="login-logo text-center mb-4">
                <img src="/images/logo.png" alt="UPG MIS Logo" class="img-fluid mb-2" style="max-width: 140px;">
                <h1 class="h5 font-weight-bold">UPG MIS</h1>
            </div>
            
            <!-- Reset Password Card -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg font-weight-bold">Reset Your Password</p>
                    <p class="text-muted mb-3">Please create a new strong password for your account.</p>
                    
                    <form @submit.prevent="submit">
                        <!-- Email -->
                        <div class="input-group mb-3">
                            <input 
                                id="email"
                                type="email" 
                                class="form-control" 
                                placeholder="Email" 
                                v-model="form.email"
                                readonly
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.email" class="text-danger text-sm mb-3">{{ form.errors.email }}</div>
                        
                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input 
                                id="password"
                                type="password" 
                                class="form-control" 
                                placeholder="New Password" 
                                v-model="form.password"
                                required
                                autofocus
                                autocomplete="new-password"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.password" class="text-danger text-sm mb-3">{{ form.errors.password }}</div>
                        
                        <!-- Confirm Password -->
                        <div class="input-group mb-3">
                            <input 
                                id="password_confirmation"
                                type="password" 
                                class="form-control" 
                                placeholder="Confirm New Password" 
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                            >
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div v-if="form.errors.password_confirmation" class="text-danger text-sm mb-3">{{ form.errors.password_confirmation }}</div>
                        
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block"
                                    :disabled="form.processing">
                                    <span v-if="form.processing">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Resetting...
                                    </span>
                                    <span v-else>Reset Password</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Back to login -->
                    <div class="text-center mt-3">
                        <Link :href="route('login')" class="text-center">
                            <i class="fas fa-arrow-left mr-1"></i> Back to login
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
