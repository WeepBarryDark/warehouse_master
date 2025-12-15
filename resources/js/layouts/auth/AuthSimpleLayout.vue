<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { Link } from '@inertiajs/vue3';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-900">
        <!-- Left Side - Brand/Visual -->
        <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-center lg:p-8">
            <div class="relative max-w-md text-center">
                <!-- Background decoration -->
                <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-purple-500/10 rounded-3xl transform rotate-6 blur-3xl"></div>
                <div class="relative bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-8 shadow-2xl">
                    <!-- Large logo -->
                    <div class="mb-6 flex justify-center">
                        <div class="flex aspect-square size-24 items-center justify-center rounded-2xl bg-gradient-to-br from-primary via-primary to-primary/80 shadow-2xl">
                            <AppLogoIcon class="size-16 fill-current text-white" />
                        </div>
                    </div>
                    
                    <!-- Brand info -->
                    <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-4">
                        Warehouse Master
                    </h2>
                    <p class="text-lg text-slate-600 dark:text-slate-300 mb-6">
                        Professional Inventory Management System
                    </p>
                    
                    <!-- Features list -->
                    <div class="text-left space-y-3">
                        <div class="flex items-center space-x-3 text-slate-700 dark:text-slate-300">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm">Real-time inventory tracking</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-700 dark:text-slate-300">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            <span class="text-sm">Advanced analytics dashboard</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-700 dark:text-slate-300">
                            <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                            <span class="text-sm">Multi-location management</span>
                        </div>
                        <div class="flex items-center space-x-3 text-slate-700 dark:text-slate-300">
                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            <span class="text-sm">Automated reporting tools</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Auth Form -->
        <div class="flex flex-1 items-center justify-center p-6 lg:p-8">
            <div class="w-full max-w-md">
                <!-- Mobile logo -->
                <div class="lg:hidden mb-8 text-center">
                    <Link :href="route('home')" class="inline-flex flex-col items-center gap-3 group">
                        <div class="flex aspect-square size-16 items-center justify-center rounded-xl bg-gradient-to-br from-primary via-primary to-primary/80 shadow-lg group-hover:shadow-xl transition-all duration-300">
                            <AppLogoIcon class="size-10 fill-current text-white" />
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-slate-800 dark:text-white">Warehouse Master</div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">Management System</div>
                        </div>
                    </Link>
                </div>
                
                <!-- Auth Card -->
                <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-white/20 dark:border-slate-700/50 rounded-2xl shadow-2xl p-8">
                    <div class="mb-8 text-center">
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ title }}</h1>
                        <p class="text-slate-600 dark:text-slate-300">{{ description }}</p>
                    </div>
                    
                    <slot />
                </div>
                
                <!-- Footer -->
                <div class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    <p>&copy; 2024 Warehouse Master. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</template>
