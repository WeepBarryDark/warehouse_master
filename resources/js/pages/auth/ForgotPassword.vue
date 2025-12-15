<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthLayout from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Mail, ArrowLeft } from 'lucide-vue-next';

defineProps<{
    status?: string;
}>();

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <AuthLayout title="Reset Your Password" description="Enter your email address and we'll send you a link to reset your password">
        <Head title="Forgot password" />

        <div v-if="status" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-center text-sm font-medium text-green-700 dark:bg-green-900/20 dark:border-green-800 dark:text-green-300">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Email Field -->
            <div class="space-y-2">
                <Label for="email" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Email Address</Label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Mail class="h-5 w-5 text-slate-400" />
                    </div>
                    <Input 
                        id="email" 
                        type="email" 
                        name="email" 
                        autocomplete="off" 
                        v-model="form.email" 
                        autofocus 
                        placeholder="Enter your email address"
                        class="pl-10 h-12 bg-slate-50 dark:bg-slate-700 border-slate-200 dark:border-slate-600 focus:border-primary focus:ring-primary/20 rounded-lg transition-all duration-200"
                    />
                </div>
                <InputError :message="form.errors.email" />
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    We'll send a secure reset link to this email address
                </div>
            </div>

            <!-- Submit Button -->
            <Button 
                type="submit"
                class="w-full h-12 bg-gradient-to-r from-blue-600 via-blue-600 to-blue-500 hover:from-blue-700 hover:via-blue-700 hover:to-blue-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]" 
                :disabled="form.processing"
            >
                <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin mr-2" />
                <span v-if="!form.processing">Send Reset Link</span>
                <span v-else>Sending...</span>
            </Button>

            <!-- Back to Login -->
            <div class="text-center pt-4">
                <TextLink 
                    :href="route('login')"
                    class="inline-flex items-center space-x-2 text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-primary transition-colors font-medium"
                >
                    <ArrowLeft class="h-4 w-4" />
                    <span>Back to Sign In</span>
                </TextLink>
            </div>
        </form>
    </AuthLayout>
</template>
