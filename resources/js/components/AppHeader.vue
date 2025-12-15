<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { NavigationMenu, NavigationMenuItem, NavigationMenuList, navigationMenuTriggerStyle } from '@/components/ui/navigation-menu';
import { Sheet, SheetContent, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Tooltip, TooltipContent, TooltipProvider, TooltipTrigger } from '@/components/ui/tooltip';
import UserMenuContent from '@/components/UserMenuContent.vue';
import { getInitials } from '@/composables/useInitials';
import type { BreadcrumbItem, NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid, Menu, Search } from 'lucide-vue-next';
import { computed } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItem[];
}

const props = withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

const page = usePage();
const auth = computed(() => page.props.auth);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const activeItemStyles = computed(
    () => (url: string) => (isCurrentRoute.value(url) ? 'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100' : ''),
);

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
];

const rightNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80 bg-gradient-to-r from-background via-background to-background/95 backdrop-blur-sm shadow-sm">
            <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
                <!-- Mobile Menu -->
                <div class="lg:hidden">
                    <Sheet>
                        <SheetTrigger :as-child="true">
                            <Button variant="ghost" size="icon" class="mr-2 h-10 w-10 group transition-all duration-300 hover:bg-green-100 hover:text-green-700 hover:shadow-lg hover:scale-105 dark:hover:bg-green-900 dark:hover:text-green-300">
                                <Menu class="h-5 w-5 transition-transform duration-200 group-hover:scale-110" />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[300px] p-6 bg-gradient-to-br from-background to-background/95 backdrop-blur-md border-r border-border/50">
                            <SheetTitle class="sr-only">Navigation Menu</SheetTitle>
                            <SheetHeader class="flex justify-start text-left">
                                <div class="flex aspect-square size-8 items-center justify-center rounded-lg bg-gradient-to-br from-primary via-primary to-primary/80 text-primary-foreground shadow-lg">
                                    <AppLogoIcon class="size-5 fill-current text-white dark:text-black" />
                                </div>
                            </SheetHeader>
                            <div class="flex h-full flex-1 flex-col justify-between space-y-4 py-6">
                                <nav class="-mx-3 space-y-2">
                                    <Link
                                        v-for="item in mainNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        class="flex items-center gap-x-3 rounded-lg px-3 py-3 text-sm font-medium transition-all duration-200 hover:bg-gradient-to-r hover:from-accent/80 hover:to-accent/40 hover:shadow-md hover:scale-[1.02]"
                                        :class="[
                                            activeItemStyles(item.href),
                                            isCurrentRoute(item.href) ? 'bg-gradient-to-r from-green-100 to-green-50 text-green-800 border border-green-200 dark:from-green-900 dark:to-green-800 dark:text-green-100 dark:border-green-700' : 'hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-800 dark:hover:from-green-900 dark:hover:to-green-800 dark:hover:text-green-100'
                                        ]"
                                    >
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5 transition-transform duration-200 hover:scale-110" />
                                        {{ item.title }}
                                    </Link>
                                </nav>
                                <div class="flex flex-col space-y-3 pt-4 border-t border-border/50">
                                    <a
                                        v-for="item in rightNavItems"
                                        :key="item.title"
                                        :href="item.href"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="flex items-center space-x-3 text-sm font-medium py-2 px-3 rounded-lg hover:bg-gradient-to-r hover:from-accent/60 hover:to-accent/30 transition-all duration-200 hover:shadow-md"
                                    >
                                        <component v-if="item.icon" :is="item.icon" class="h-5 w-5 opacity-80" />
                                        <span>{{ item.title }}</span>
                                    </a>
                                </div>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>

                <Link :href="route('dashboard')" class="flex items-center gap-x-2 group transition-all duration-200 hover:scale-[1.02]">
                    <div class="relative">
                        <AppLogo />
                        <div class="absolute inset-0 rounded-lg bg-gradient-to-br from-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></div>
                    </div>
                </Link>

                <!-- Desktop Menu -->
                <div class="hidden h-full lg:flex lg:flex-1">
                    <NavigationMenu class="ml-10 flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-1">
                            <NavigationMenuItem v-for="(item, index) in mainNavItems" :key="index" class="relative flex h-full items-center group">
                                <Link
                                    :class="[
                                        navigationMenuTriggerStyle(), 
                                        activeItemStyles(item.href), 
                                        'h-10 cursor-pointer px-4 relative overflow-hidden transition-all duration-300 hover:shadow-md hover:scale-[1.02]',
                                        isCurrentRoute(item.href) ? 'bg-gradient-to-r from-green-100 to-green-50 text-green-800 dark:from-green-900 dark:to-green-800 dark:text-green-100' : 'hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-800 dark:hover:from-green-900 dark:hover:to-green-800 dark:hover:text-green-100'
                                    ]"
                                    :href="item.href"
                                >
                                    <component v-if="item.icon" :is="item.icon" class="mr-2 h-4 w-4 transition-transform duration-200 group-hover:scale-110" />
                                    <span class="font-medium">{{ item.title }}</span>
                                    <div class="absolute inset-x-0 bottom-0 h-0.5 bg-gradient-to-r from-green-600 to-green-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left"></div>
                                </Link>
                                <div
                                    v-if="isCurrentRoute(item.href)"
                                    class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-gradient-to-r from-green-600 via-green-500 to-green-400 animate-pulse"
                                ></div>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>

                <div class="ml-auto flex items-center space-x-2">
                    <div class="relative flex items-center space-x-1">
                        <Button variant="ghost" size="icon" class="group h-10 w-10 cursor-pointer relative overflow-hidden transition-all duration-300 hover:bg-green-100 hover:text-green-700 hover:shadow-lg hover:scale-105 dark:hover:bg-green-900 dark:hover:text-green-300">
                            <Search class="size-5 opacity-80 group-hover:opacity-100 transition-all duration-200 group-hover:scale-110" />
                        </Button>

                        <div class="hidden space-x-1 lg:flex">
                            <template v-for="item in rightNavItems" :key="item.title">
                                <TooltipProvider :delay-duration="0">
                                    <Tooltip>
                                        <TooltipTrigger>
                                            <Button variant="ghost" size="icon" as-child class="group h-10 w-10 cursor-pointer relative overflow-hidden transition-all duration-300 hover:bg-green-100 hover:text-green-700 hover:shadow-lg hover:scale-105 dark:hover:bg-green-900 dark:hover:text-green-300">
                                                <a :href="item.href" target="_blank" rel="noopener noreferrer">
                                                    <span class="sr-only">{{ item.title }}</span>
                                                    <component :is="item.icon" class="size-5 opacity-80 group-hover:opacity-100 transition-all duration-200 group-hover:scale-110" />
                                                </a>
                                            </Button>
                                        </TooltipTrigger>
                                        <TooltipContent class="bg-gradient-to-br from-popover to-popover/95 border border-border/50 shadow-xl">
                                            <p class="font-medium">{{ item.title }}</p>
                                        </TooltipContent>
                                    </Tooltip>
                                </TooltipProvider>
                            </template>
                        </div>
                    </div>

                    <DropdownMenu>
                        <DropdownMenuTrigger :as-child="true">
                            <Button
                                variant="ghost"
                                size="icon"
                                class="relative size-11 w-auto rounded-full p-1 group transition-all duration-300 hover:shadow-lg hover:scale-105 focus-within:ring-2 focus-within:ring-primary/50 focus-within:ring-offset-2"
                            >
                                <div class="relative">
                                    <Avatar class="size-9 overflow-hidden rounded-full ring-2 ring-transparent group-hover:ring-primary/30 transition-all duration-300">
                                        <AvatarImage v-if="auth.user.avatar" :src="auth.user.avatar" :alt="auth.user.name" class="transition-transform duration-300 group-hover:scale-105" />
                                        <AvatarFallback class="rounded-full bg-gradient-to-br from-primary/90 to-primary font-semibold text-primary-foreground transition-all duration-300 group-hover:from-primary group-hover:to-primary/80">
                                            {{ getInitials(auth.user?.name) }}
                                        </AvatarFallback>
                                    </Avatar>
                                    <div class="absolute -bottom-0.5 -right-0.5 size-3 bg-green-500 rounded-full border-2 border-background animate-pulse"></div>
                                </div>
                            </Button>
                        </DropdownMenuTrigger>
                        <DropdownMenuContent align="end" class="w-56 bg-gradient-to-br from-popover to-popover/95 border border-border/50 shadow-xl backdrop-blur-sm">
                            <UserMenuContent :user="auth.user" />
                        </DropdownMenuContent>
                    </DropdownMenu>
                </div>
            </div>
        </div>

        <div v-if="props.breadcrumbs.length > 1" class="flex w-full border-b border-sidebar-border/70 bg-gradient-to-r from-muted/30 to-transparent">
            <div class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl">
                <Breadcrumbs :breadcrumbs="breadcrumbs" />
            </div>
        </div>
    </div>
</template>
