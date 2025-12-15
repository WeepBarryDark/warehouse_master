<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle, User, Mail, Lock, Eye, EyeOff } from 'lucide-vue-next';
import { ref } from 'vue';

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

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
    <AuthBase title="Join Warehouse Master" description="Create your account to start managing your inventory efficiently">
        <Head title="Register" />

        <form @submit.prevent="submit" class="space-y-6">
            <!-- Name Field -->
            <div class="space-y-2">
                <Label for="name" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Full Name</Label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <User class="h-5 w-5 text-slate-400" />
                    </div>
                    <Input 
                        id="name" 
                        type="text" 
                        required 
                        autofocus 
                        :tabindex="1" 
                        autocomplete="name" 
                        v-model="form.name" 
                        placeholder="Enter your full name"
                        class="pl-10 h-12 bg-slate-50 dark:bg-slate-700 border-slate-200 dark:border-slate-600 focus:border-primary focus:ring-primary/20 rounded-lg transition-all duration-200"
                    />
                </div>
                <InputError :message="form.errors.name" />
            </div>

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
                        :tabindex="2" 
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
                <Label for="password" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Password</Label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Lock class="h-5 w-5 text-slate-400" />
                    </div>
                    <Input
                        id="password"
                        :type="showPassword ? 'text' : 'password'"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        v-model="form.password"
                        placeholder="Create a strong password"
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
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Password should be at least 8 characters with letters and numbers
                </div>
            </div>

            <!-- Confirm Password Field -->
            <div class="space-y-2">
                <Label for="password_confirmation" class="text-sm font-semibold text-slate-700 dark:text-slate-300">Confirm Password</Label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <Lock class="h-5 w-5 text-slate-400" />
                    </div>
                    <Input
                        id="password_confirmation"
                        :type="showPasswordConfirmation ? 'text' : 'password'"
                        required
                        :tabindex="4"
                        autocomplete="new-password"
                        v-model="form.password_confirmation"
                        placeholder="Confirm your password"
                        class="pl-10 pr-10 h-12 bg-slate-50 dark:bg-slate-700 border-slate-200 dark:border-slate-600 focus:border-primary focus:ring-primary/20 rounded-lg transition-all duration-200"
                    />
                    <button
                        type="button"
                        @click="showPasswordConfirmation = !showPasswordConfirmation"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors"
                        :tabindex="-1"
                    >
                        <Eye v-if="!showPasswordConfirmation" class="h-5 w-5" />
                        <EyeOff v-else class="h-5 w-5" />
                    </button>
                </div>
                <InputError :message="form.errors.password_confirmation" />
            </div>

            <!-- Terms Agreement -->
            <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 text-sm text-slate-600 dark:text-slate-400">
                <p>By creating an account, you agree to our <TextLink href="#" class="text-primary hover:text-primary/80 font-medium">Terms of Service</TextLink> and <TextLink href="#" class="text-primary hover:text-primary/80 font-medium">Privacy Policy</TextLink>.</p>
            </div>

            <!-- Create Account Button -->
            <Button 
                type="submit" 
                class="w-full h-12 bg-gradient-to-r from-green-600 via-green-600 to-green-500 hover:from-green-700 hover:via-green-700 hover:to-green-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] active:scale-[0.98]" 
                tabindex="5" 
                :disabled="form.processing"
            >
                <LoaderCircle v-if="form.processing" class="h-5 w-5 animate-spin mr-2" />
                <span v-if="!form.processing">Create Your Account</span>
                <span v-else>Creating Account...</span>
            </Button>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200 dark:border-slate-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400">Already have an account?</span>
                </div>
            </div>

            <!-- Sign In Link -->
            <div class="text-center">
                <TextLink 
                    :href="route('login')" 
                    tabindex="6"
                    class="inline-flex items-center justify-center w-full h-12 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 font-medium rounded-lg transition-all duration-200 hover:scale-[1.02]"
                >
                    Sign In to Existing Account
                </TextLink>
            </div>
        </form>
    </AuthBase>
</template>
