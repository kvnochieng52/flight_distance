<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>

<template>
    <Head title="Email Verification" />
    
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- Logo -->
            <div class="login-logo text-center mb-4">
                <img src="/images/logo.png" alt="UPG MIS Logo" class="img-fluid mb-2" style="max-width: 140px;">
                <h1 class="h5 font-weight-bold">UPG MIS</h1>
            </div>
            
            <!-- Email Verification Card -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg font-weight-bold">Email Verification</p>
                    
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link
                        we just emailed to you? If you didn't receive the email, we will gladly send you another.
                    </div>
                    
                    <div v-if="verificationLinkSent" class="alert alert-success mb-3">
                        <i class="fas fa-check-circle mr-2"></i>
                        A new verification link has been sent to your email address.
                    </div>
                    
                    <form @submit.prevent="submit">
                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block mb-3"
                                    :disabled="form.processing">
                                    <span v-if="form.processing">
                                        <i class="fas fa-spinner fa-spin mr-1"></i> Sending...
                                    </span>
                                    <span v-else>
                                        <i class="fas fa-envelope mr-1"></i> Resend Verification Email
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Logout Link -->
                    <div class="text-center">
                        <Link 
                            :href="route('logout')"
                            method="post"
                            as="button"
                            class="btn btn-outline-secondary">
                            <i class="fas fa-sign-out-alt mr-1"></i> Log Out
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
</style>
