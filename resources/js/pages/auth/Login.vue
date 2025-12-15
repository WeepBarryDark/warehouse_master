<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, Mail, Lock, Eye, EyeOff } from 'lucide-vue-next';
import { ref } from 'vue';

const showPassword = ref(false);

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();

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
    <AuthBase title="Welcome Back" description="Sign in to access your warehouse management dashboard">
        <Head title="Log in" />

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
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        v-model="form.email"
                        placeholder="Enter your email address"
                        class="pl-10 h-12 bg-slate-50 dark:bg-slate-700 border-slate-200 dark:border-slate-600 focus:border-primary focus:ring-primary/20 rounded-lg transition-all duration-200"
                    />
                </div>
                <InputError :message="form.errors.email" />
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <Label for="password" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Password</Label>
                    <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm text-primary hover:text-primary/80 font-medium" :tabindex="5">
                        Forgot password?
                    </TextLink>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Lock class="h-5 w-5 text-slate-400" />
                    </div>
                    <Input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        v-model="form.password"
                        placeholder="Enter your password"
                        class="pl-10 pr-10 h-12 bg-slate-50 dark:bg-slate-700 border-slate-200 dark:border-slate-600 focus:border-primary focus:ring-primary/20 rounded-lg transition-all duration-200"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors"
                        :tabindex="-1"
                    >
                        <Eye v-if="!showPassword" class="h-5 w-5" />
                        <EyeOff v-else class="h-5 w-5" />
                    </button>
                </div>
                <InputError :message="form.errors.password" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between pt-2">
                <Label for="remember" class="flex items-center space-x-3 cursor-pointer group">
                    <Checkbox id="remember" v-model="form.remember" :tabindex="3" class="data-[state=checked]:bg-primary data-[state=checked]:border-primary" />
                    <span class="text-sm text-slate-600 dark:text-slate-400 group-hover:text-slate-800 dark:group-hover:text-slate-200 transition-colors">Keep me signed in</span>
                </Label>
            </div>

            <!-- Login Button -->
            <Button 
                type="submit" 
                class="w-full h-12 bg-gradient-to-r from-green-600 via-green-600 to-green-500 hover:from-green-700 hover:via-green-700 hover:to-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]" 
                :tabindex="4" 
                :disabled="form.processing"
            >
                <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin mr-2" />
                <span v-if="!form.processing">Sign In to Dashboard</span>
                <span v-else>Signing In...</span>
            </Button>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400">New to Warehouse Master?</span>
                </div>
            </div>

            <!-- Sign Up Link -->
            <div class="text-center">
                <TextLink 
                    :href="route('register')" 
                    :tabindex="5"
                    class="inline-flex items-center justify-center w-full h-12 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 font-medium rounded-lg transition-all duration-200 hover:scale-[1.02]"
                >
                    Create New Account
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
