<script setup lang="ts">
import AppLogoIcon from '@/components/AppLogoIcon.vue';
</script>

<template>
    <div class="flex aspect-square size-9 items-center justify-center rounded-lg bg-gradient-to-br from-green-600 via-green-600 to-green-500 text-white shadow-lg ring-1 ring-green-500/20 transition-all duration-300 hover:shadow-xl hover:scale-105">
        <AppLogoIcon class="size-5 fill-current text-white dark:text-white transition-transform duration-300 hover:scale-110" />
        <div class="absolute inset-0 rounded-lg bg-gradient-to-br from-white/20 to-transparent opacity-60"></div>
    </div>
    <div class="ml-2 grid flex-1 text-left text-sm">
        <span class="mb-0.5 truncate leading-tight font-bold bg-gradient-to-r from-foreground to-foreground/80 bg-clip-text text-transparent">Warehouse Master</span>
        <span class="text-xs text-muted-foreground font-medium opacity-75">Management System</span>
    </div>
</template>
